<?php

namespace App\Console\Commands;
use App\Http\Controllers\Layanan\RalanController;
use Illuminate\Console\Command;
use App\Http\Traits\Token;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;
use App\Http\Traits\RequestAPI;

class SDMCron extends Command
{
    use Token, RequestAPI, RequestDB;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:sdm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job SDM BIOS';
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
        $this->getPerawat();
    }

    public function getPerawat()
    {
        $url = 'kesehatan/sdm/perawat';
        $bidang = 'PERAWAT';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($response->body());
    }
}
