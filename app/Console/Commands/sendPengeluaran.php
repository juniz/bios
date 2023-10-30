<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Traits\RequestAPI;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\Token;
use App\Http\Traits\RequestDB;
use App\Http\Traits\Telegram;
use Illuminate\Support\Carbon;

class sendPengeluaran extends Command
{
    use Token, RequestAPI, RequestDB, Telegram;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kirim:pengeluaran';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim pengeluaran ke bios';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = 'keuangan/akuntansi/pengeluaran';
        $token = $this->getToken()->json()['token'];
        $header = [
            'token' => $token,
            'Content-Type' => 'multipart/form-data'
        ];
        $i = 0;
        $pengeluaran = DB::table('bios_pengeluaran')->get();
        foreach ($pengeluaran as $data) {
            $body = array(
                'tgl_transaksi' => $data->tgl_transaksi,
                'kd_akun' => $data->kd_akun,
                'jumlah' => $data->jumlah,
            );
            $response = $this->postData($url, $header, $body, 'bios_log_pengeluaran');
            $i++;
            $this->info('#' . $i . ' - ' . $response->body());
        }
    }
}
