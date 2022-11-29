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
    public $token, $header, $tanggal, $now;

    public function __construct()
   {
        parent::__construct();
        
   }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->init();
        $this->postPerawat();
        $this->postAdministrasi();
        $this->postDokterGigi();
        $this->postDokterUmum();
        $this->postPranataLaboratorium();
        $this->postTenagaNonMedis();
        $this->postNutritionist();
        $this->postPharmacist();
        $this->postProfesionalLain();
        $this->postRadiographer();
        $this->postSanitarian();
        $this->postDokterSpesialis();
    }

    public function init()
    {
        $token = $this->getToken();
        $this->token = $token->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ]; 
        $this->tanggal = Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
    }

    public function postPerawat()
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
        $this->info($this->now.' '.$this->description.' '.$bidang.':'.$response->body());
    }

    public function postAdministrasi()
    {
        $url = 'kesehatan/sdm/non_medis_administrasi';
        $bidang = 'TENAGA NON MEDIS ADMINISTRASI';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
            'keterangan' => 'Umum, Keuangan, SDM, Humas, BMN',
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($this->now.' '.$this->description.' '.$bidang.':'.$response->body());
    }

    public function postBidan()
    {
        $url = 'kesehatan/sdm/bidan';
        $bidang = 'BIDAN';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($this->now.' '.$this->description.' '.$bidang.':'.$response->body());
    }

    public function postDokterGigi()
    {
        $url = 'kesehatan/sdm/dokter_gigi';
        $bidang = 'DOKTER GIGI';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($this->now.' '.$this->description.' '.$bidang.':'.$response->body());
    }

    public function postDokterUmum()
    {
        $url = 'kesehatan/sdm/dokter_umum';
        $bidang = 'DOKTER UMUM';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($this->now.' '.$this->description.' '.$bidang.':'.$response->body());
    }

    public function postPranataLaboratorium()
    {
        $url = 'kesehatan/sdm/pranata_laboratorium';
        $bidang = 'PRANATA LABORATORIUM';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($this->now.' '.$this->description.' '.$bidang.':'.$response->body());
    }

    public function postTenagaNonMedis()
    {
        $url = 'kesehatan/sdm/non_medis_administrasi';
        $bidang = 'TENAGA NON MEDIS';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
            'keterangan' => 'Umum, Keuangan, SDM, Humas, BMN',
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($this->now.' '.$this->description.' '.$bidang.':'.$response->body());
    }

    public function postNutritionist()
    {
        $url = 'kesehatan/sdm/nutritionist';
        $bidang = 'NUTRITIONIST';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($this->now.' '.$this->description.' '.$bidang.':'.$response->body());
    }

    public function postPharmacist()
    {
        $url = 'kesehatan/sdm/pharmacist';
        $bidang = 'PHARMACIST';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($this->now.' '.$this->description.' '.$bidang.':'.$response->body());
    }

    public function postProfesionalLain()
    {
        $url = 'kesehatan/sdm/profesional_lain';
        $bidang = 'TENAGA PROFESIONAL LAINNYA';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($this->now.' '.$this->description.' '.$bidang.':'.$response->body());
    }

    public function postRadiographer()
    {
        $url = 'kesehatan/sdm/radiographer';
        $bidang = 'RADIOGRAPHER';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($this->now.' '.$this->description.' '.$bidang.':'.$response->body());
    }

    public function postSanitarian()
    {
        $url = 'kesehatan/sdm/sanitarian';
        $bidang = 'SANITARIAN';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($this->now.' '.$this->description.' '.$bidang.':'.$response->body());
    }

    public function postDokterSpesialis()
    {
        $url = 'kesehatan/sdm/dokter_spesialis';
        $bidang = 'DOKTER SPESIALIS';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $response = $this->postData($url, $this->header, $input);
        $this->info($this->now.' '.$this->description.' '.$bidang.':'.$response->body());
    }
}
