<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Traits\RequestAPI;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\Token;
use App\Http\Traits\RequestDB;
use App\Http\Traits\Telegram;
use Illuminate\Support\Carbon;

class sendSaldo extends Command
{
    use Token, RequestAPI, RequestDB, Telegram;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kirim:saldo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim saldo ke bios';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = 'keuangan/saldo/saldo_operasional';
        $token = $this->getToken()->json()['token'];
        $header = [
            'token' => $token,
            'Content-Type' => 'multipart/form-data'
        ];
        $i = 0;
        $kas = DB::table('bios_saldo')->get();
        foreach ($kas as $data) {
            $body = array(
                'tgl_transaksi' => $data->tgl_transaksi,
                'kdbank' => $data->kd_bank,
                'no_rekening' => $data->norek,
                'unit' => 'RS BHAYANGKARA NGANJUK',
                'saldo_akhir' => $data->saldo,
            );
            $response = $this->postData($url, $header, $body, 'bios_log_operasional');
            $i++;
            $this->info('#' . $i . ' - ' . $response->body());
        }
    }
}
