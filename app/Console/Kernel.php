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
        $schedule->command('cron:sdm')->weekly()->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_sdm.log'));

        $tanggal = Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $jam = strtotime('09:45');
        $lab = $this->countLab($tanggal);
        foreach($lab as $l){
            $time = date("H:i", strtotime('+2 minutes', $jam));;
            $schedule->command('cron:labparam '.$l->kd_jenis_prw.' '.$l->jml)->daily()->at($time)->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
            $jam = strtotime($time);
        }

        $schedule->command('cron:poli')->daily()->at(date("H:i", strtotime('+60 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        $schedule->command('cron:operasi')->daily()->at(date("H:i", strtotime('+62 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        $schedule->command('cron:igd')->daily()->at(date("H:i", strtotime('+70 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        $schedule->command('cron:penjab')->daily()->at(date("H:i", strtotime('+75 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        $schedule->command('cron:radiologi')->daily()->at(date("H:i", strtotime('+80 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        $schedule->command('cron:ralan')->daily()->at(date("H:i", strtotime('+85 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        $schedule->command('cron:farmasi')->daily()->at(date("H:i", strtotime('+90 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
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
