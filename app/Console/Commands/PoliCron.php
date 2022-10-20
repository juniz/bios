<?php

namespace App\Console\Commands;
use App\Http\Controllers\Layanan\RalanController;
use Illuminate\Console\Command;
use App\Http\Traits\Token;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;
use App\Http\Traits\RequestAPI;

class PoliCron extends Command
{
    use Token, RequestAPI, RequestDB;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:poli';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job Poli BIOS';
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
        $this->postLayananPoli();
    }

    public function postLayananPoli()
    {
        $url = 'kesehatan/layanan/pasien_ralan_poli';
        $bidang = 'POLI';
        $poli = $this->countPoli($this->tanggal);
        foreach($poli as $p){
            $input = array(
                'tgl_transaksi' => $this->tanggal,
                'nama_poli' => $p->nm_poli,
                'jumlah' => $p->jml,
            );
            $response = $this->postData($url, $this->header, $input);
            $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
            $this->info($now.'|'.$this->description.'-'.$p->nm_poli.'|'.$bidang.'|'.$response->body());
        }
    }
 
}
