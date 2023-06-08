<?php

namespace App\Http\Controllers\Layanan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class RadiologiController extends Controller
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
        $this->url = 'kesehatan/layanan/radiologi';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Jumlah', 'Status', 'Send at', 'Updated at', 'Aksi'];
        $this->tanggal = $request->input('tgl') ?? Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->keterangan = [
            'Data yang dikirimkan merupakan posisi data terakhir pada saat tanggal berkenaan, tidak akumulatif.',
            'Data dikirimkan per periode harian.',
        ];
    }

    public function index()
    {
        return view('layanan.radiologi',[
            'data' => $this->data, 
            'head' => $this->headTable, 
            'jumlah' => $this->countRadiologi($this->tanggal),
            'tanggal' => $this->tanggal,
            'keterangan' => $this->keterangan,
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        unset($input['_token']);
        $response = $this->postData($this->url, $this->header, $input, 'bios_log_radiologi');
        return $response->json();
    }

    public function read()
    {
        return $this->bacaLog('bios_log_radiologi');
    }
}
