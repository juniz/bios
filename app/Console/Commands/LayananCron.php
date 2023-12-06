<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Traits\Token;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\Telegram;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class LayananCron extends Command
{
    use Token, RequestAPI, RequestDB, Telegram;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:layanan {tahun?} ';

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
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // for ($i = 1; $i <= 31; $i++) {
        //     $tgl = $i < 10 ? '0' . $i : $i;
        //     $this->init($tgl);
        // }
        if(empty($this->argument('tahun'))){
            $this->init();
        }else{
            $periode = CarbonPeriod::create($this->argument('tahun'). '-01-01', $this->argument('tahun').'-12-31');
            foreach ($periode as $date) {
                $this->init($date->format('Y-m-d'));
            }
        }
        // $this->init();
    }

    public function init($tgl = null)
    {
        $this->token = $this->getToken()->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ];
        // $tgl = empty($tgl) ? null : '2022-12-' . $tgl ;
        $tanggal = $tgl ??  Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->count = 0;
        // $this->sendMessage('Cron job Layanan BIOS telah dijalankan pada ' . Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss')); 

        $this->postLayananFarmasi($tanggal);
        $this->postLayananIGD($tanggal);
        $this->postLayananPoli($tanggal);
        $this->postLayananOperasi($tanggal);
        $this->postLayananRadiologi($tanggal);
        $this->postLayananRalan($tanggal);
        $this->postLayananPenjab($tanggal);
        $this->postLayananLabParameter($tanggal);
        $this->postLayananLabSample($tanggal);
        $this->postLayananRanap($tanggal);
    }

    public function postLayananFarmasi($tanggal)
    {
        $url = 'kesehatan/layanan/farmasi';
        $bidang = 'FARMASI';
        $jumlah = $this->countFarmasi($tanggal);
        $input = array(
            'tgl_transaksi' => $tanggal,
            'jumlah' => $jumlah
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_farmasi', $this->count == 20 ? 600 : 0);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#' . $this->count . '.' . $tanggal . ' ' . $this->description . ' ' . $bidang . ':' . $response->body() ?? '500');
        $this->count++;
    }

    public function postLayananIGD($tanggal)
    {
        $url = 'kesehatan/layanan/pasien_igd';
        $bidang = 'IGD';
        $jumlah = $this->countIGD($tanggal);
        $input = array(
            'tgl_transaksi' => $tanggal,
            'jumlah' => $jumlah,
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_igd', $this->count == 20 ? 600 : 0);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#' . $this->count . '.' . $tanggal . ' ' . $this->description . ' ' . $bidang . ':' . $response->body() ?? '500');
        $this->count++;
    }

    public function postLayananPoli($tanggal)
    {
        $url = 'kesehatan/layanan/pasien_ralan_poli';
        $bidang = 'POLI';
        $poli = $this->countPoli($tanggal);
        foreach ($poli as $p) {
            $input = array(
                'tgl_transaksi' => $tanggal,
                'nama_poli' => $p->nm_poli,
                'jumlah' => $p->jml,
            );
            $response = $this->postData($url, $this->header, $input, 'bios_log_poli', $this->count == 20 ? 600 : 0);
            $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
            $this->info('#' . $this->count . '.' . $tanggal . ' ' . $this->description . ' ' . $bidang . ':' . $response->body() ?? '500');
            $this->count++;
        }
    }

    public function postLayananOperasi($tanggal)
    {
        $url = 'kesehatan/layanan/operasi';
        $bidang = 'OPERASI';
        $operasi = $this->countOperasi($tanggal);
        foreach ($operasi as $o) {
            $input = array(
                'tgl_transaksi' => $tanggal,
                'klasifikasi_operasi' => $o->kategori,
                'jumlah' => $o->jml,
            );
            $response = $this->postData($url, $this->header, $input, 'bios_log_operasi', $this->count == 20 ? 600 : 0);
            $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
            $this->info('#' . $this->count . '.' . $tanggal . ' ' . $this->description . ' ' . $bidang . ':' . $response->body() ?? '500');
            $this->count++;
        }
    }

    public function postLayananRadiologi($tanggal)
    {
        $url = 'kesehatan/layanan/radiologi';
        $bidang = 'RADIOLOGI';
        $jumlah =  $this->countRadiologi($tanggal);
        $input = array(
            'tgl_transaksi' => $tanggal,
            'jumlah' => $jumlah,
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_radiologi', $this->count == 20 ? 600 : 0);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#' . $this->count . '.' . $tanggal . ' ' . $this->description . ' ' . $bidang . ':' . $response->body() ?? '500');
        $this->count++;
    }

    public function postLayananRalan($tanggal)
    {
        $url = 'kesehatan/layanan/pasien_ralan';
        $bidang = 'RALAN';
        $jumlah =  $this->countRalan($tanggal);
        $input = array(
            'tgl_transaksi' => $tanggal,
            'jumlah' => $jumlah,
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_ralan', 0);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#' . $this->count . '.' . $tanggal . ' ' . $this->description . ' ' . $bidang . ':' . $response->body() ?? '500');
        $this->count++;
    }

    public function postLayananPenjab($tanggal)
    {
        $url = 'kesehatan/layanan/bpjs_nonbpbjs';
        $bidang = 'BPJS DAN NON BPJS';
        $jumlah_bpjs =  $this->countBPJS($tanggal);
        $jumlah_non_bpjs =  $this->countNonBPJS($tanggal);
        $input = array(
            'tgl_transaksi' => $tanggal,
            'jumlah_bpjs' => $jumlah_bpjs,
            'jumlah_non_bpjs' => $jumlah_non_bpjs,
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_bpjs', $this->count == 20 ? 600 : 0);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#' . $this->count . '.' . $tanggal . ' ' . $this->description . ' ' . $bidang . ':' . $response->body() ?? '500');
        $this->count++;
    }

    public function postLayananLabParameter($tanggal)
    {
        $url = 'kesehatan/layanan/laboratorium_detail';
        $bidang = 'LABORATORIUM PARAMETER';
        $lab = $this->countLab($tanggal);
        foreach ($lab as $l) {
            $input = array(
                'tgl_transaksi' => $tanggal,
                'nama_layanan' => $l->nm_perawatan,
                'jumlah' => $l->jml,
            );
            $response = $this->postData($url, $this->header, $input, 'bios_log_lab_parameter', $this->count == 20 ? 600 : 0);
            $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
            $this->info('#' . $this->count . '.' . $tanggal . ' ' . $this->description . ' ' . $bidang . ':' . $response->body() ?? 'timeout');
            $this->count++;
        }
    }

    public function postLayananLabSample($tanggal)
    {
        $url = 'kesehatan/layanan/laboratorium';
        $bidang = 'LABORATORIUM SAMPLE';
        $jumlah = $this->getLab($tanggal);
        $input = array(
            'tgl_transaksi' => $tanggal,
            'jumlah' =>  $jumlah,
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_lab_sample', $this->count == 20 ? 600 : 0);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#' . $this->count . '.' . $tanggal . ' ' . $this->description . ' ' . $bidang . ':' . $response->body() ?? '500');
        $this->count++;
    }

    public function postLayananRanap($tanggal)
    {
        $url = 'kesehatan/layanan/pasien_ranap';
        $bidang = 'PASIEN RANAP';
        $ranap = $this->counRanap($tanggal);
        foreach ($ranap as $l) {
            $input = array(
                'tgl_transaksi' => $tanggal,
                'kode_kelas' => $l->kelas,
                'jumlah' => $l->jml,
            );
            $response = $this->postData($url, $this->header, $input, 'bios_log_ranap', 0);
            $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
            $this->info('#' . $this->count . '.' . $tanggal . ' ' . $this->description . ' ' . $bidang . ':' . $response->body() ?? '500');
            $this->count++;
        }
    }
}
