<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\SDMCron::class,
        Commands\LayananCron::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('cron:sdm')->daily()->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_sdm.log'));
        $schedule->command('cron:labparam')->daily('01:00')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        $schedule->command('cron:igd')->daily('01:30')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        $schedule->command('cron:operasi')->daily('02:00')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        $schedule->command('cron:penjab')->daily('02:30')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        $schedule->command('cron:poli')->daily('03:00')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        $schedule->command('cron:radiologi')->daily('03:30')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        $schedule->command('cron:ralan')->daily('04:00')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
