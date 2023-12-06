<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Traits\RequestAPI;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\Token;
use App\Http\Traits\RequestDB;
use App\Http\Traits\Telegram;
use Illuminate\Support\Carbon;

class SendRanap extends Command
{
    use Token, RequestAPI, RequestDB, Telegram;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kirim:ranap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim ranap ke bios';
    public $token, $header, $tanggal, $now, $count;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = 'kesehatan/layanan/pasien_ranap';
        $bidang = 'PASIEN RANAP';
        for($i = 1; $i <= 30; $i++){
            $tanggal = '2023-04-' . $i;
            $ranap = $this->counRanap($tanggal);
            foreach ($ranap as $l) {
                $input = array(
                    'tgl_transaksi' => $tanggal,
                    'kode_kelas' => $l->kelas,
                    'jumlah' => $l->jml,
                );
                $response = $this->postData($url, $this->header, $input, 'bios_log_ranap', $this->count == 20 ? 600 : 0);
                $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
                $this->info('#' . $this->count . '.' . $now . ' ' . $this->description . ' ' . $bidang . ':' . $response->body() ?? '500');
                // $this->count == 20 ? $this->count = 1 :  $this->count++;
            }
        }
    }
}
