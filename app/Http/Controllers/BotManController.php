<?php

namespace App\Http\Controllers;
use BotMan\BotMan\BotMan;
use App\Conversations\ExampleConversation;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use App\Conversations\SheduleTaskConversation;
use Illuminate\Support\Facades\Artisan;

class BotManController extends Controller
{
    public function handle()
    {
        // Load the driver(s) you want to use
        DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);
 
        $config = [
            // Your driver-specific configuration
            "telegram" => [
               "token" => "5477847783:AAGtzHNIoCqHAPaDGYFs6kkplywERNAdoeA"
            ]
        ];
        $botman = BotManFactory::create($config, new LaravelCache());
 
        $botman->hears('/start|start|mulai', function (BotMan $bot) {
            $user = $bot->getUser();
            $bot->reply('Selamat datang '.$user->getFirstName().'');
            $bot->startConversation(new SheduleTaskConversation());
        })->stopsConversation();
 
        // $botman->hears('/kitab|kitab', function (BotMan $bot) {
        //     $bot->startConversation(new ExampleConversation());
        // })->stopsConversation();
 
        // $botman->hears('/lapor|lapor|laporkan', function (BotMan $bot) {
        //     $bot->reply('Silahkan laporkan di email weare@zalabs.my.id . Laporan kamu akan sangat berharga buat kemajuan bot ini.');
        // })->stopsConversation();
 
        $botman->hears('/bios', function (BotMan $bot) {
            Artisan::call('cron:layanan');
            $bot->reply('Task Schedul Telah dijalankan.');
        })->stopsConversation();
 
        $botman->listen();
    }
 
}
