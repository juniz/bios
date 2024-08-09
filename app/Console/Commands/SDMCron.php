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
    public $token, $header, $tanggal, $now, $count;

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
        $this->postBidan();
        $this->postAdministrasi();
        $this->postDokterGigi();
        $this->postDokterUmum();
        $this->postPranataLaboratorium();
        $this->postTenagaNonMedis();
        $this->postNonMedis();
        $this->postNutritionist();
        $this->postPharmacist();
        $this->postProfesionalLain();
        $this->postRadiographer();
        $this->postSanitarian();
        $this->postDokterSpesialis();
        $this->postFisioterapis();
    }

    public function init()
    {
        $this->token = $this->getToken()->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ];
        $this->tanggal = Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->count = 0;
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
        $this->postDataSDM($url, $this->header, $input, 'bios_log_perawat',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
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
        $this->postDataSDM($url, $this->header, $input, 'bios_log_administrasi',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
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
        $this->postDataSDM($url, $this->header, $input, 'bios_log_bidan',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
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
        $this->postDataSDM($url, $this->header, $input, 'bios_log_dokter_gigi',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
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
        $this->postDataSDM($url, $this->header, $input, 'bios_log_dokter_umum',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
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
        $this->postDataSDM($url, $this->header, $input, 'bios_log_laboratorium',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
    }

    public function postTenagaNonMedis()
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
        $this->postDataSDM($url, $this->header, $input, 'bios_log_tenaga_non_medis',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
    }

    public function postNonMedis()
    {
        $url = 'kesehatan/sdm/non_medis';
        $bidang = 'TENAGA NON MEDIS';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $this->postDataSDM($url, $this->header, $input, 'bios_log_non_medis',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
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
        $this->postDataSDM($url, $this->header, $input, 'bios_log_nutritionist',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
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
        $this->postDataSDM($url, $this->header, $input, 'bios_log_pharmacist',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
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
        $this->postDataSDM($url, $this->header, $input, 'bios_log_profesional_lainnya',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
    }

    public function postRadiographer()
    {
        $url = 'kesehatan/sdm/radiographer';
        $bidang = 'RADIOGRAFER';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $this->postDataSDM($url, $this->header, $input, 'bios_log_radiographer',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
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
        $this->postDataSDM($url, $this->header, $input, 'bios_log_sanitarian',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
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
        $this->postDataSDM($url, $this->header, $input, 'bios_log_spesialis',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
    }

    public function postFisioterapis()
    {
        $url = 'kesehatan/sdm/fisioterapis';
        $bidang = 'FISIOTERAPIS';
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'pns' =>  $this->pns($bidang),
            'pppk' => $this->p3k($bidang),
            'anggota' => $this->anggota($bidang),
            'non_pns_tetap' => $this->nonPNS($bidang),
            'kontrak' =>  $this->kontrak($bidang),
        );
        $this->postDataSDM($url, $this->header, $input, 'bios_log_fisioterapis',  $this->count == 20 ? 600 : 0);
        $this->count == 20 ? $this->count = 0 :  $this->count++;
    }
}
