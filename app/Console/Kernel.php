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
    use RequestDB, Token;
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
        
        // $layanan =$this->taskSetting('layanan');
        $schedule->command('cron:bulanan')->daily()->at('11:44')->timezone('Asia/Jakarta')->before(function(){
            $this->sendMessage('Cron job Bulanan BIOS telah dijalankan pada ' . Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss'));
        })->after(function(){
            $this->sendMessage('Cron job Bulanan BIOS telah selesai pada ' . Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss'));
        });
        // $schedule->command('cron:sdm')->weekly()->timezone('Asia/Jakarta')->appendOutputTo(storage_path('logs/cron_sdm.log'));

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
