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

class BulananCron extends Command
{
    use Token, RequestAPI, RequestDB, Telegram;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:bulanan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job Layanan Bulanan';
    public $token, $header, $tanggal, $tgl, $now, $count;

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
        $this->token = Cache::get('token') ?? $this->getToken()->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ]; 
        $this->tanggal = Carbon::now()->subMonth()->isoFormat('YYYY-MM-DD');
        $this->tgl = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
        $this->now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        $this->count = 1;
        
        $this->postBOR();
        $this->postALOS();
        $this->postTOI();
        $this->postBTO();
    }

    public function postBOR()
    {
        $url = 'kesehatan/layanan/bor';
        $bidang = 'BOR';
        $jumlah = $this->countBOR();
        $input = array(
            'tgl_transaksi' => $this->tgl,
            'bor' => $jumlah
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_bor', $this->count == 20 ? 600 : 0);
        // $data = [
        //     'uuid'  =>  Str::uuid(),
        //     'tgl_transaksi' => $this->tgl,
        //     'bor' => $jumlah,
        //     'user'  =>  'server',
        //     'response' => $response->json()['status'] ?? 500,
        //     'send_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ];
        // $this->simpanLog('bios_log_bor', $data);
        // $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        // $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body());
        $this->count == 20 ? $this->count = 1 :  $this->count++;
    }

    public function postALOS()
    {
        $url = 'kesehatan/layanan/alos';
        $bidang = 'ALOS';
        $jumlah = $this->countALOS();
        $input = array(
            'tgl_transaksi' => $this->tgl,
            'alos' => $jumlah
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_alos', $this->count == 20 ? 600 : 0);
        // $data = [
        //     'uuid'  =>  Str::uuid(),
        //     'tgl_transaksi' => $this->tgl,
        //     'alos' => $jumlah,
        //     'user'  =>  'server',
        //     'response' => $response->json()['status'] ?? 500,
        //     'send_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ];
        // $this->simpanLog('bios_log_alos', $data);
        // $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        // $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body());
        $this->count == 20 ? $this->count = 1 :  $this->count++;
    }

    public function postTOI()
    {
        $url = 'kesehatan/layanan/toi';
        $bidang = 'TOI';
        $jumlah = $this->countTOI();
        $input = array(
            'tgl_transaksi' => $this->tgl,
            'toi' => $jumlah
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_toi', $this->count == 20 ? 600 : 0);
        // $data = [
        //     'uuid'  =>  Str::uuid(),
        //     'tgl_transaksi' => $this->tgl,
        //     'toi' => $jumlah,
        //     'user'  =>  'server',
        //     'response' => $response->json()['status'] ?? 500,
        //     'send_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ];
        // $this->simpanLog('bios_log_toi', $data);
        // $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        // $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body());
        $this->count == 20 ? $this->count = 1 :  $this->count++;
    }

    public function postBTO()
    {
        $url = 'kesehatan/layanan/bto';
        $bidang = 'BTO';
        $jumlah = $this->countBTO();
        $input = array(
            'tgl_transaksi' => $this->tgl,
            'bto' => $jumlah
        );
        $response = $this->postData($url, $this->header, $input, 'bios_log_bto', $this->count == 20 ? 600 : 0);
        // $data = [
        //     'uuid'  =>  Str::uuid(),
        //     'tgl_transaksi' => $this->tgl,
        //     'bto' => $jumlah,
        //     'user'  =>  'server',
        //     'response' => $response->json()['status'] ?? 500,
        //     'send_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ];
        // $this->simpanLog('bios_log_bto', $data);
        // $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
        // $this->info('#'.$this->count.'.'.$now.' '.$this->description.' '.$bidang.':'.$response->body());
        $this->count == 20 ? $this->count = 1 :  $this->count++;
    }

}
