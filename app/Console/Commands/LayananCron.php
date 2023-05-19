<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Http\Traits\Token;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\Telegram;
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
   }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $this->init();
        
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
        // $this->sendMessage('Cron job Layanan BIOS telah dijalankan pada ' . Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss')); 

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
        $jumlah = $this->countFarmasi($this->tanggal);
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'jumlah' => $jumlah
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_farmasi', $this->count == 20 ? 600 : 0);
        // $data = [
        //     'uuid'  =>  Str::uuid(),
        //     'tgl_transaksi' => $this->tanggal,
        //     'jumlah' => $jumlah,
        //     'user'  =>  'server',
        //     'response' => $response->json()['status'] ?? 500,
        //     'send_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ];
        // $this->simpanLog('bios_log_farmasi', $data);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body() ?? '500');
        $this->count == 20 ? $this->count = 0 :  $this->count++;
    }

    public function postLayananIGD()
    {
        $url = 'kesehatan/layanan/pasien_igd';
        $bidang = 'IGD';
        $jumlah = $this->countIGD($this->tanggal);
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'jumlah' => $jumlah,
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_igd', $this->count == 20 ? 600 : 0);
        // $data = [
        //     'uuid'  =>  Str::uuid(),
        //     'tgl_transaksi' => $this->tanggal,
        //     'jumlah' => $jumlah,
        //     'user'  =>  'server',
        //     'response' => $response->json()['status'] ?? 500,
        //     'send_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ];
        // $this->simpanLog('bios_log_igd', $data);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body() ?? '500');
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
            $response = $this->postData($url, $this->header, $input, 'bios_log_poli', $this->count == 20 ? 600 : 0);
            // $data = [
            //     'uuid'  =>  Str::uuid(),
            //     'tgl_transaksi' => $this->tanggal,
            //     'nama_poli' => $p->nm_poli,
            //     'jumlah' => $p->jml,
            //     'user'  =>  'server',
            //     'response' => $response->json()['status'] ?? 500,
            //     'send_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ];
            // $this->simpanLog('bios_log_poli', $data);
            $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
            $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body() ?? '500');
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
            $response = $this->postData($url, $this->header, $input, 'bios_log_operasi', $this->count == 20 ? 600 : 0);
            // $data = [
            //     'uuid'  =>  Str::uuid(),
            //     'tgl_transaksi' => $this->tanggal,
            //     'klasifikasi_operasi' => $o->kategori,
            //     'jumlah' => $o->jml,
            //     'user'  =>  'server',
            //     'response' => $response->json()['status'] ?? 500,
            //     'send_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ];
            // $this->simpanLog('bios_log_operasi', $data);
            $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
            $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body() ?? '500');
            $this->count == 20 ? $this->count = 1 :  $this->count++;
        }
    }

    public function postLayananRadiologi()
    {
        $url = 'kesehatan/layanan/radiologi';
        $bidang = 'RADIOLOGI';
        $jumlah =  $this->countRadiologi($this->tanggal);
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'jumlah' => $jumlah,
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_radiologi', $this->count == 20 ? 600 : 0);
        // $data = [
        //     'uuid'  =>  Str::uuid(),
        //     'tgl_transaksi' => $this->tanggal,
        //     'jumlah' => $jumlah,
        //     'user'  =>  'server',
        //     'response' => $response->json()['status'] ?? 500,
        //     'send_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ];
        // $this->simpanLog('bios_log_radiologi', $data);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body() ?? '500');
        $this->count == 20 ? $this->count = 1 :  $this->count++;
    }

    public function postLayananRalan()
    {
        $url = 'kesehatan/layanan/pasien_ralan';
        $bidang = 'RALAN';
        $jumlah =  $this->countRalan($this->tanggal);
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'jumlah' => $jumlah,
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_ralan', $this->count == 20 ? 600 : 0);
        // $data = [
        //     'uuid'  =>  Str::uuid(),
        //     'tgl_transaksi' => $this->tanggal,
        //     'jumlah' => $jumlah,
        //     'user'  =>  'server',
        //     'response' => $response->json()['status'] ?? 500,
        //     'send_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ];
        // $this->simpanLog('bios_log_ralan', $data);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body() ?? '500');
        $this->count == 20 ? $this->count = 1 :  $this->count++;
    }

    public function postLayananPenjab()
    {
        $url = 'kesehatan/layanan/bpjs_nonbpbjs';
        $bidang = 'BPJS DAN NON BPJS';
        $jumlah_bpjs =  $this->countBPJS($this->tanggal);
        $jumlah_non_bpjs =  $this->countNonBPJS($this->tanggal);
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'jumlah_bpjs' => $jumlah_bpjs,
            'jumlah_non_bpjs' => $jumlah_non_bpjs,
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_bpjs', $this->count == 20 ? 600 : 0);
        // $data = [
        //     'uuid'  =>  Str::uuid(),
        //     'tgl_transaksi' => $this->tanggal,
        //     'jumlah_bpjs' => $jumlah_bpjs,
        //     'jumlah_non_bpjs' => $jumlah_non_bpjs,
        //     'user'  =>  'server',
        //     'response' => $response->json()['status'] ?? 500,
        //     'send_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ];
        // $this->simpanLog('bios_log_bpjs', $data);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body() ?? '500');
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
            $response = $this->postData($url, $this->header, $input, 'bios_log_lab_parameter', $this->count == 20 ? 600 : 0);
            // $data = [
            //     'uuid'  =>  Str::uuid(),
            //     'tgl_transaksi' => $this->tanggal,
            //     'nama_layanan' => $l->nm_perawatan,
            //     'jumlah' => $l->jml,
            //     'user'  =>  'server',
            //     'response' => $response->json()['status'] ?? 500,
            //     'send_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ];
            // $this->simpanLog('bios_log_lab_parameter', $data);
            $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
            $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body() ?? 'timeout');
            $this->count == 20 ? $this->count = 1 :  $this->count++;
        }
    }

    public function postLayananLabSample()
    {
        $url = 'kesehatan/layanan/laboratorium';
        $bidang = 'LABORATORIUM SAMPLE';
        $jumlah = $this->getLab($this->tanggal);
        $input = array(
            'tgl_transaksi' => $this->tanggal,
            'jumlah' =>  $jumlah,
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_lab_sample', $this->count == 20 ? 600 : 0);
        // $data = [
        //     'uuid'  =>  Str::uuid(),
        //     'tgl_transaksi' => $this->tanggal,
        //     'jumlah' => $jumlah,
        //     'user'  =>  'server',
        //     'response' => $response->json()['status'] ?? 500,
        //     'send_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ];
        // $this->simpanLog('bios_log_lab_sample', $data);
        $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body() ?? '500');
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
            $response = $this->postData($url, $this->header, $input, 'bios_log_ranap', $this->count == 20 ? 600 : 0);
            // $data = [
            //     'uuid'  =>  Str::uuid(),
            //     'tgl_transaksi' => $this->tanggal,
            //     'kode_kelas' => $l->kelas,
            //     'jumlah' => $l->jml,
            //     'user'  =>  'server',
            //     'response' => $response->json()['status'] ?? 500,
            //     'send_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ];
            // $this->simpanLog('bios_log_ranap', $data);
            $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
            $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body() ?? '500');
            $this->count == 20 ? $this->count = 1 :  $this->count++;
        }
    }
 
}
