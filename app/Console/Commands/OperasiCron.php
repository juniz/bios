<?php

namespace App\Console\Commands;
use App\Http\Controllers\Layanan\RalanController;
use Illuminate\Console\Command;
use App\Http\Traits\Token;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;
use App\Http\Traits\RequestAPI;

class OperasiCron extends Command
{
    use Token, RequestAPI, RequestDB;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:operasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job Operasi BIOS';
    public $token, $header, $tanggal;

    public function __construct()
   {
        parent::__construct();
        $token = $this->getToken();
        $this->token = $token->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ]; 
        $this->tanggal = Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
   }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->postLayananOperasi();
    }

    public function postLayananOperasi()
    {
        $url = 'kesehatan/layanan/operasi';
        $bidang = 'OPERASI';
        $operasi = $this->countOperasi($this->tanggal);
        foreach($operasi as $o){
            $input = array(
                'tgl_transaksi' => $this->tanggal,
                'klasifikasi_operasi' => $o->kategori,
                'jumlah' => $o->jml,
            );
            $response = $this->postData($url, $this->header, $input);
            $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
            $this->info($now.'|'.$this->description.'-'.$o->kategori.'|'.$bidang.'|'.$response->body());
        }
    }
 
}
