<?php

namespace App\Http\Controllers\Layanan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\Token;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class BPJSNonBPJSController extends Controller
{
    use Token, RequestAPI, RequestDB;
    public $header, $token, $url, $data, $headTable, $tanggal, $keterangan;

    public function __construct(Request $request)
    {
        $this->token = Cache::get('token') ?? $this->getToken()->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ]; 
        $this->url = 'kesehatan/layanan/bpjs_nonbpbjs';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Jumlah BPJS', 'Jumlah Non BPJS', 'Status', 'Send at', 'Updated at', 'Aksi'];
        $this->tanggal = $request->input('tgl') ?? Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->keterangan = [
            'Data yang dikirimkan merupakan posisi data terakhir pada saat tanggal berkenaan, tidak akumulatif.',
            'Data dikirimkan per periode harian.',
        ];
    }

    public function index()
    {
        return view('layanan.bpjs-nonbpjs',[
            'data' => $this->data, 
            'head' => $this->headTable, 
            'tanggal' => $this->tanggal,
            'jumlah_BPJS' => $this->countBPJS($this->tanggal),
            'jumlah_Non_BPJS' => $this->countNonBPJS($this->tanggal),
            'keterangan' => $this->keterangan,
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        unset($input['_token']);
        $response = $this->postData($this->url, $this->header, $input, 'bios_log_bpjs');
        return $response->json();
    }

    public function read()
    {
        return $this->bacaLog('bios_log_bpjs');
    }
}
