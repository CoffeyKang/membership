<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {   
        // Schedule daily reset of staff status to active at 00:01 AM
        $schedule->command('set:staff-active')->daily()->at('10:40');
    
        // Schedule daily backups at 2 AM
        $schedule->command('backup:run --only-db')->daily()->at('10:40');
        
        // Schedule weekly cleanup of old backups
        $schedule->command('backup:clean')->weekly();
        
        // Schedule daily health checks
        $schedule->command('backup:monitor')->daily();
        
        
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}