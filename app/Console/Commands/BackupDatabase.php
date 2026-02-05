<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-database {--type=full : Type of backup (full, database, files)} {--force : Force backup even if it fails health checks}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a database backup using spatie/laravel-backup package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');
        $force = $this->option('force');

        $this->info('Starting backup process...');

        $commandOptions = [];
        
        // Only add --only-db flag since we're specifically doing database backups
        $commandOptions['--only-db'] = true;

        if ($force) {
            $commandOptions['--force'] = true;
        }

        $exitCode = Artisan::call('backup:run', $commandOptions);

        if ($exitCode === 0) {
            $this->info('Database backup completed successfully!');
            
            // Show the list of backups
            $this->call('backup:list');
        } else {
            $this->error('Database backup failed!');
            $this->error(Artisan::output());
        }

        return $exitCode;
    }
}
