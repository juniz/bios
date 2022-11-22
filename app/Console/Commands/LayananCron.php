<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Http\Traits\Token;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\Telegram;

class LayananCron extends Command
{
    use Token, RequestAPI, RequestDB, Telegram;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:layanan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job Layanan BIOS';
    public $token, $header, $tanggal, $now, $count;

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
        $this->now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->count = 1; 
   }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->sendMessage('Cron job Layanan BIOS telah dijalankan pada ' . Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss'));
        $this->postLayananFarmasi();
        $this->postLayananIGD();
        $this->postLayananPoli();
        $this->postLayananOperasi();
        $this->postLayananRadiologi();
        $this->postLayananRalan();
        $this->postLayananPenjab();
        $this->postLayananLabParameter();
        $this->postLayananLabSample();
        $this->postLayananRanap();
    }

    public function postLayananFarmasi()
    {
        $url = 'kesehatan/layanan/farmasi';
        $bidang = 'FARMASI';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'jumlah' => $this->countFarmasi($this->tanggal),
        );
        $response = $this->postData($url, $this->header, $input, $this->count == 20 ? 600 : 0);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body());
        $this->count == 20 ? $this->count = 1 :  $this->count++;
    }

    public function postLayananIGD()
    {
        $url = 'kesehatan/layanan/pasien_igd';
        $bidang = 'IGD';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'jumlah' => $this->countIGD($this->tanggal),
        );
        $response = $this->postData($url, $this->header, $input, $this->count == 20 ? 600 : 0);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body());
        $this->count == 20 ? $this->count = 1 :  $this->count++;
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
            $response = $this->postData($url, $this->header, $input, $this->count == 20 ? 600 : 0);
            $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
            $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.'-'.$p->nm_poli.':'.$response->body());
            $this->count == 20 ? $this->count = 1 :  $this->count++;
        }
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
            $response = $this->postData($url, $this->header, $input, $this->count == 20 ? 600 : 0);
            $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
            $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.'-'.$o->kategori.':'.$response->body());
            $this->count == 20 ? $this->count = 1 :  $this->count++;
        }
    }

    public function postLayananRadiologi()
    {
        $url = 'kesehatan/layanan/radiologi';
        $bidang = 'RADIOLOGI';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'jumlah' => $this->countRadiologi($this->tanggal),
        );
        $response = $this->postData($url, $this->header, $input, $this->count == 20 ? 600 : 0);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body());
        $this->count == 20 ? $this->count = 1 :  $this->count++;
    }

    public function postLayananRalan()
    {
        $url = 'kesehatan/layanan/pasien_ralan';
        $bidang = 'RALAN';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'jumlah' => $this->countRalan($this->tanggal),
        );
        $response = $this->postData($url, $this->header, $input, $this->count == 20 ? 600 : 0);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body());
        $this->count == 20 ? $this->count = 1 :  $this->count++;
    }

    public function postLayananPenjab()
    {
        $url = 'kesehatan/layanan/bpjs_nonbpbjs';
        $bidang = 'BPJS DAN NON BPJS';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'jumlah_bpjs' => $this->countBPJS($this->tanggal),
            'jumlah_non_bpjs' => $this->countNonBPJS($this->tanggal),
        );
        $response = $this->postData($url, $this->header, $input, $this->count == 20 ? 600 : 0);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body());
        $this->count == 20 ? $this->count = 1 :  $this->count++;
    }

    public function postLayananLabParameter()
    {
        $url = 'kesehatan/layanan/laboratorium_detail';
        $bidang = 'LABORATORIUM PARAMETER';
        $lab = $this->countLab($this->tanggal);
        foreach($lab as $l){
            $input = array(
                'tgl_transaksi' => $this->tanggal,
                'nama_layanan' => $l->nm_perawatan,
                'jumlah' => $l->jml,
            );
            $response = $this->postData($url, $this->header, $input, $this->count == 20 ? 600 : 0);
            $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
            $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.'-'.$l->nm_perawatan.':'.$response->body());
            $this->count == 20 ? $this->count = 1 :  $this->count++;
        }
    }

    public function postLayananLabSample()
    {
        $url = 'kesehatan/layanan/laboratorium';
        $bidang = 'LABORATORIUM SAMPLE';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'jumlah' =>  $this->getLab($this->tanggal),
        );
        $response = $this->postData($url, $this->header, $input, $this->count == 20 ? 600 : 0);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body());
        $this->count == 20 ? $this->count = 1 :  $this->count++;
    }

    public function postLayananRanap()
    {
        $url = 'kesehatan/layanan/pasien_ranap';
        $bidang = 'PASIEN RANAP';
        $ranap = $this->counRanap($this->tanggal);
        foreach($ranap as $l){
            $input = array(
                'tgl_transaksi' => $this->tanggal,
                'kode_kelas' => $l->kelas,
                'jumlah' => $l->jml,
            );
            $response = $this->postData($url, $this->header, $input, $this->count == 20 ? 600 : 0);
            $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
            $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.'-'.$l->kelas.':'.$response->body());
            $this->count == 20 ? $this->count = 1 :  $this->count++;
        }
    }
 
}
