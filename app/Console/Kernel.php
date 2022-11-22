<?php

namespace App\Console;

use App\Http\Traits\RequestDB;
use App\Http\Traits\Telegram;
use Illuminate\Support\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Traits\Token;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    use RequestDB, Token, Telegram;
    protected $commands = [
        // Commands\SDMCron::class,
        // Commands\LabParamCron::class,
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
        $this->sendMessage('Cron job Layanan BIOS telah dijalankan pada ' . Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss'));
        $layanan =$this->taskSetting('layanan');
        $schedule->command('cron:layanan')->daily()->at($layanan->jam)->timezone('Asia/Jakarta')->appendOutputTo(storage_path($layanan->log));
        // $schedule->command('cron:sdm')->weekly()->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_sdm.log'));

        // $tanggal = Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        // $token = $this->getToken()->json()['token'];
        // $jam = strtotime('15:49');
        // $lab = $this->countLab($tanggal);
        // $jmlReq = 1;
        // foreach($lab as $l){
        //     $time = date("H:i", strtotime($jmlReq == 20 ? '+20 minutes' : '+1 minutes', $jam));;
        //     $schedule->command('cron:labparam '.$l->kd_jenis_prw.' '.$l->jml.' '.$tanggal.' '.$token)->daily()->at($time)->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        //     $jam = strtotime($time);
        //     $jmlReq == 20 ? $jmlReq = 0 : $jmlReq++;
        // }

        // $schedule->command('cron:poli')->daily()->at(date("H:i", strtotime('+1 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:operasi')->daily()->at(date("H:i", strtotime('+62 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:igd')->daily()->at(date("H:i", strtotime('+70 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:penjab')->daily()->at(date("H:i", strtotime('+75 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:radiologi')->daily()->at(date("H:i", strtotime('+80 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:ralan')->daily()->at(date("H:i", strtotime('+85 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
        // $schedule->command('cron:farmasi')->daily()->at(date("H:i", strtotime('+90 minutes', $jam)))->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_layanan.log'));
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
