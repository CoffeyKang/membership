<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class BackupManager extends Component
{
    public $backups = [];
    public $isBackingUp = false;

    protected $listeners = [
        'refreshBackups' => 'loadBackups',
    ];

    public function mount()
    {
        $this->loadBackups();
    }

    public function render()
    {
        return view('livewire.backup-manager');
    }

    public function loadBackups()
    {
        try {
            // Run the backup:list command and parse the output
            $exitCode = Artisan::call('backup:list');
            $output = Artisan::output();
            
            $this->parseTableOutput($output);
        } catch (\Exception $e) {
            $this->addError('error', 'Error loading backups: ' . $e->getMessage());
        }
    }

    private function parseTableOutput($output)
    {
        // The backup:list command shows summary information, not individual files
        // We need to get the actual backup files from the storage directory
        $backups = [];
        
        $backupDir = storage_path('app/private/人民发艺');
        if (is_dir($backupDir)) {
            $files = array_diff(scandir($backupDir), array('.', '..'));
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
                    $filePath = $backupDir . '/' . $file;
                    $fileTime = filemtime($filePath);
                    $fileSize = filesize($filePath);
                    
                    $backups[] = [
                        'disk' => 'local',
                        'date' => date('Y-m-d H:i:s', $fileTime),
                        'path' => '人民发艺/' . $file, // Just the relative path
                        'size' => $this->formatBytes($fileSize)
                    ];
                }
            }
        }
        
        // Sort backups by date (newest first)
        usort($backups, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        $this->backups = $backups;
    }
    
    private function formatBytes($size, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }

    public function createBackup()
    {
        $this->isBackingUp = true;
        
        // Add flash message for starting backup
        session()->flash('message', 'Starting backup process...');
        session()->flash('messageType', 'info');

        try {
            $exitCode = Artisan::call('backup:run', [
                '--only-db' => true
            ]);
            
            if ($exitCode === 0) {
                session()->flash('message', __('messages.backup_created_successfully'));
                session()->flash('messageType', 'success');
            } else {
                session()->flash('message', __('messages.backup_failed') . ': ' . Artisan::output());
                session()->flash('messageType', 'error');
            }
        } catch (\Exception $e) {
            session()->flash('message', __('messages.backup_error') . ': ' . $e->getMessage());     
            session()->flash('messageType', 'error');
        }

        $this->isBackingUp = false;
        $this->loadBackups(); // Refresh the backup list
        
        // Refresh the component to show the flash message
        return redirect(request()->header('Referer'));
    }

    public function cleanupBackups()
    {
        // Add flash message for starting cleanup
        session()->flash('message', 'Cleaning up old backups...');
        session()->flash('messageType', 'info');

        try {
            $exitCode = Artisan::call('backup:clean');
            
            if ($exitCode === 0) {
                session()->flash('message', __('messages.backup_cleaned_successfully'));
                session()->flash('messageType', 'success');
            } else {
                session()->flash('message', __('messages.backup_cleanup_failed') . ': ' . Artisan::output());
                session()->flash('messageType', 'error');
            }
        } catch (\Exception $e) {
            session()->flash('message', __('messages.backup_cleanup_error') . ': ' . $e->getMessage()); 
            session()->flash('messageType', 'error');
        }

        $this->loadBackups(); // Refresh the backup list
        
        // Refresh the component to show the flash message
        return redirect(request()->header('Referer'));
    }

    public function downloadBackup($path)
    {
        // Construct the full path to the backup file
        $fullPath = storage_path('app/private/' . $path);
        
        // Check if the file exists
        if (!file_exists($fullPath)) {
            session()->flash('message', __('messages.backup_file_not_found') . ': ' . $path);
            session()->flash('messageType', 'error');
            return redirect(request()->header('Referer'));
        }
        
        // Set success message before initiating download
        session()->flash('message', __('messages.backup_download_initiated'));
        session()->flash('messageType', 'info');
        
        // Generate a unique token and store the file path in cache
        $token = \Illuminate\Support\Str::random(32);
        \Illuminate\Support\Facades\Cache::put('backup_download_' . $token, [
            'file_path' => $fullPath
        ], 30); // Expire in 30 seconds
        
        // Use JavaScript to open the download URL in a new tab/window
        $this->js("window.open('" . route('download.backup', ['token' => $token]) . "', '_blank')");
        
        return redirect(request()->header('Referer'));
    }

    public function refreshBackups()
    {
        $this->loadBackups();
        
        // Add flash message
        session()->flash('message', __('messages.backup_information_refreshed'));
        session()->flash('messageType', 'info');
        
        // Refresh the component to show the flash message
        return redirect(request()->header('Referer'));
    }
}
