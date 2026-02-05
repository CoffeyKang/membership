<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class BackupManager extends Component
{
    public $backups = [];
    public $isBackingUp = false;
    public $message = '';
    public $messageType = ''; // success, error, info

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
            
            // Parse the command output to extract backup information
            $lines = explode("\n", $output);
            $backups = [];
            
            foreach ($lines as $line) {
                // Skip header lines
                if (strpos($line, 'Hostname') !== false || strpos($line, '+-') === 0 || trim($line) === '') {
                    continue;
                }
                
                // Parse backup info from the table format
                if (preg_match('/\|\s*(.*?)\s*\|\s*(.*?)\s*\|\s*(.*?)\s*\|\s*(.*?)\s*\|/', $line, $matches)) {
                    $backups[] = [
                        'disk' => trim($matches[1]),
                        'date' => trim($matches[2]),
                        'path' => trim($matches[3]),
                        'size' => trim($matches[4])
                    ];
                }
            }
            
            $this->backups = $backups;
        } catch (\Exception $e) {
            $this->setMessage('Error loading backups: ' . $e->getMessage(), 'error');
        }
    }

    public function createBackup()
    {
        $this->isBackingUp = true;
        $this->setMessage('Starting backup process...', 'info');

        try {
            $exitCode = Artisan::call('backup:run', ['--only-db']);
            
            if ($exitCode === 0) {
                $this->setMessage('Database backup created successfully!', 'success');
            } else {
                $this->setMessage('Backup failed: ' . Artisan::output(), 'error');
            }
        } catch (\Exception $e) {
            $this->setMessage('Error creating backup: ' . $e->getMessage(), 'error');
        }

        $this->isBackingUp = false;
        $this->loadBackups(); // Refresh the backup list
    }

    public function cleanupBackups()
    {
        $this->setMessage('Cleaning up old backups...', 'info');

        try {
            $exitCode = Artisan::call('backup:clean');
            
            if ($exitCode === 0) {
                $this->setMessage('Old backups cleaned successfully!', 'success');
            } else {
                $this->setMessage('Cleanup failed: ' . Artisan::output(), 'error');
            }
        } catch (\Exception $e) {
            $this->setMessage('Error cleaning backups: ' . $e->getMessage(), 'error');
        }

        $this->loadBackups(); // Refresh the backup list
    }

    public function downloadBackup($path)
    {
        // For security reasons, we'll just provide a message
        // Actual download would require additional security considerations
        $this->setMessage('Download functionality would be implemented here. Path: ' . $path, 'info');
    }

    public function setMessage($message, $type)
    {
        $this->message = $message;
        $this->messageType = $type;
    }

    public function clearMessage()
    {
        $this->message = '';
        $this->messageType = '';
    }
}
