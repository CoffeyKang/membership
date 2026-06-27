<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withCommands([
        __DIR__.'/../app/Console/Commands/*.php',
    ])
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        // Schedule daily backups at 2 AM
        $schedule->command('backup:run')->daily()->at('02:00');

        // Schedule weekly cleanup of old backups
        $schedule->command('backup:clean')->weekly();

        // Schedule daily health checks
        $schedule->command('backup:monitor')->daily();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
