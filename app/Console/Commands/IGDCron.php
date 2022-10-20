<?php

namespace App\Console\Commands;
use App\Http\Controllers\Layanan\RalanController;
use Illuminate\Console\Command;
use App\Http\Traits\Token;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;
use App\Http\Traits\RequestAPI;

class IGDCron extends Command
{
    use Token, RequestAPI, RequestDB;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:igd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job IGD BIOS';
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
        $this->postLayananIGD();
    }

    public function postLayananIGD()
    {
        $url = 'kesehatan/layanan/pasien_igd';
        $bidang = 'IGD';
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'jumlah' => $this->countIGD($this->tanggal),
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($now.'|'.$this->description.'|'.$bidang.'|'.$response->body());
    }
 
}
