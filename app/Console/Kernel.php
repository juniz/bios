<?php

namespace App\Console;

use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    use RequestDB;
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
        // $schedule->command('cron:labparam')->daily('01:00')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:igd')->daily('01:30')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:operasi')->daily('02:00')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:penjab')->daily('02:30')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:poli')->daily('03:00')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:radiologi')->daily('03:30')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:ralan')->daily('04:00')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));

        $tanggal = Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $jam = Carbon::now();
        $lab = $this->countLab($tanggal);
        foreach($lab as $l){
            $time = "$jam->addMinutes(5)->isoFormat('HH:mm')";
            $schedule->command('cron:labparam '.$l->kd_jenis_prw.' '.$l->jml)->daily()->at($time)->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        }
        // $schedule->command('cron:labparam')->daily()->at('11:20')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:igd')->daily()->at('11:20')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:operasi')->daily()->at('11:20')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:penjab')->daily()->at('11:20')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:poli')->daily()->at('11:20')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:radiologi')->daily()->at('11:20')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:ralan')->daily()->at('11:20')->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
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
