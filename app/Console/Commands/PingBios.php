<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\Telegram;
use Illuminate\Support\Facades\Cache;

class PingBios extends Command
{
    use Telegram;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:ping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek koneksi ke server bios kemenkeu';

    private $url = 'https://bios.kemenkeu.go.id';
    private $status = 'Down';

    public function __construct()
    {
        parent::__construct();
        $this->status = Cache::get('status', 'Down');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get($this->url);
        if ($response->status() != 200) {
            if ($this->status == 'Up') {
                $this->sendMessage('Tidak bisa terhubung ke server BIOS Kemenkeu');
                Cache::put('status', 'Down', 60);
            }
        } else {
            if ($this->status == 'Down') {
                $this->sendMessage('Koneksi ke server BIOS Kemenkeu sudah normal kembali');
                Cache::put('status', 'Up', 60);
            }
        }
    }
}
