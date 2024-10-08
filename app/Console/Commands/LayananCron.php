<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Traits\Token;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\Telegram;
use App\Models\Visite1;
use App\Models\Visite2;
use App\Models\Visite3;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\VisitePertama;

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
        $this->postVisitePertama($tanggal);
        $this->postVisite1($tanggal);
        $this->postVisite2($tanggal);
        $this->postVisite3($tanggal);
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
        $response = $this->postData($url, $this->header, $input, 'bios_log_farmasi', 0);
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
        $response = $this->postData($url, $this->header, $input, 'bios_log_igd', 0);
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
            $response = $this->postData($url, $this->header, $input, 'bios_log_poli', 0);
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
            $response = $this->postData($url, $this->header, $input, 'bios_log_operasi', 0);
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
        $response = $this->postData($url, $this->header, $input, 'bios_log_radiologi', 0);
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
        $response = $this->postData($url, $this->header, $input, 'bios_log_bpjs', 0);
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
            $response = $this->postData($url, $this->header, $input, 'bios_log_lab_parameter', 0);
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
        $response = $this->postData($url, $this->header, $input, 'bios_log_lab_sample', 0);
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

    public function postVisitePertama($tanggal)
    {
        $url = 'kesehatan/ikt/visite_pertama';
        try{

            $jumlah = $this->countVisitePertama($tanggal);
            $input = array(
                'tgl_transaksi' => $tanggal,
                'jumlah' => $jumlah->jml
            );
            $response = $this->sendData($url, $input);
            if($response->successful()){
                
                VisitePertama::updateOrCreate([
                    'tgl_transaksi' => $tanggal
                ],[
                    'jumlah' => $jumlah->jml,
                    'kode' => $response->status(),
                    'status' => $response->json()['status'],
                    'response' => $response->body(),
                ]);

            }else{

                VisitePertama::updateOrCreate([
                    'tgl_transaksi' => $tanggal
                ],[
                    'jumlah' => $jumlah,
                    'kode' => $response->status() ?? 500,
                    'status' => $response->json()['status'] ?? '500',
                    'response' => $response->body() ?? 'Error Server',
                ]);

            }

            $this->info($url . ' : ' . $response->body() ?? '500');

        }catch(\Exception $e){

            $this->info($url . ' : ' . $e->getMessage() ?? '500');
            $this->sendMessage('Error Visite Pertama : ' . $e->getMessage() ?? '500');
        }
    }

    public function postVisite1($tanggal)
    {
        $url = 'kesehatan/ikt/visite_1';
        try{

            $jumlah = $this->countVisite1($tanggal);
            $input = array(
                'tgl_transaksi' => $tanggal,
                'jumlah' => $jumlah
            );
            $response = $this->sendData($url, $input);
            if($response->successful()){
                
                Visite1::updateOrCreate([
                    'tgl_transaksi' => $tanggal
                ],[
                    'jumlah' => $jumlah,
                    'kode' => $response->status(),
                    'status' => $response->json()['status'],
                    'response' => $response->body(),
                ]);

            }else{

                Visite1::updateOrCreate([
                    'tgl_transaksi' => $tanggal
                ],[
                    'jumlah' => $jumlah,
                    'kode' => $response->status() ?? 408,
                    'status' => $response->json()['status'] ?? 'Request Timeout',
                    'response' => $response->body() ?? 'Request Timeout',
                ]);

            }

            $this->info($url . ' (' . $tanggal . ') : ' . $response->body() ?? 'Request Timeout');

        }catch(\Exception $e){

            $this->info($url . ' : ' . $e->getMessage() ?? '500');
            $this->sendMessage('Error Visite 1 : ' . $e->getMessage() ?? '500');
        }
    }

    public function postVisite2($tanggal)
    {
        $url = 'kesehatan/ikt/visite_2';
        try{

            $jumlah = $this->countVisite2($tanggal);
            $input = array(
                'tgl_transaksi' => $tanggal,
                'jumlah' => $jumlah
            );
            $response = $this->sendData($url, $input);
            if($response->successful()){
                
                Visite2::updateOrCreate([
                    'tgl_transaksi' => $tanggal
                ],[
                    'jumlah' => $jumlah,
                    'kode' => $response->status(),
                    'status' => $response->json()['status'],
                    'response' => $response->body(),
                ]);

            }else{

                Visite2::updateOrCreate([
                    'tgl_transaksi' => $tanggal
                ],[
                    'jumlah' => $jumlah,
                    'kode' => $response->status() ?? 408,
                    'status' => $response->json()['status'] ?? 'Request Timeout',
                    'response' => $response->body() ?? 'Request Timeout',
                ]);

            }

            $this->info($url . ' (' . $tanggal . ') : ' . $response->body() ?? 'Request Timeout');

        }catch(\Exception $e){

            $this->info($url . ' : ' . $e->getMessage() ?? '500');
            $this->sendMessage('Error Visite 2 : ' . $e->getMessage() ?? '500');
        }
    }

    public function postVisite3($tanggal)
    {
        $url = 'kesehatan/ikt/visite_3';
        try{

            $jumlah = $this->countVisite3($tanggal);
            $input = array(
                'tgl_transaksi' => $tanggal,
                'jumlah' => $jumlah
            );
            $response = $this->sendData($url, $input);
            if($response->successful()){
                
                Visite3::updateOrCreate([
                    'tgl_transaksi' => $tanggal
                ],[
                    'jumlah' => $jumlah,
                    'kode' => $response->status(),
                    'status' => $response->json()['status'],
                    'response' => $response->body(),
                ]);

            }else{

                Visite3::updateOrCreate([
                    'tgl_transaksi' => $tanggal
                ],[
                    'jumlah' => $jumlah,
                    'kode' => $response->status() ?? 408,
                    'status' => $response->json()['status'] ?? 'Request Timeout',
                    'response' => $response->body() ?? 'Request Timeout',
                ]);

            }

            $this->info($url . ' (' . $tanggal . ') : ' . $response->body() ?? 'Request Timeout');

        }catch(\Exception $e){

            $this->info($url . ' : ' . $e->getMessage() ?? '500');
            $this->sendMessage('Error Visite 3 : ' . $e->getMessage() ?? '500');
        }
    }
}
