<?php

namespace App\Http\Controllers\Layanan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use Illuminate\Support\Facades\Cache;

class AlosController extends Controller
{
    use Token, RequestAPI, RequestDB;
    public $header, $token, $url, $data, $headTable, $keterangan;

    public function __construct()
    {
        $this->token = Cache::get('token') ?? $this->getToken()->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ];
        $this->url = 'kesehatan/layanan/alos';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'ALOS', 'Status', 'Send at', 'updated at', 'Aksi'];
        $this->keterangan = [
            'Data yang dikirimkan merupakan posisi data terakhir pada saat tanggal berkenaan, tidak akumulatif.',
            'Data dikirimkan per periode bulanan.',
        ];
    }

    public function index()
    {
        return view('layanan.alos',[
            'data' => $this->data, 
            'head' => $this->headTable,
            'keterangan' => $this->keterangan, 
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $response = $this->postData($this->url, $this->header, $input, 'bios_log_alos');
        return $response->json();
    }

    public function read()
    {
        return $this->bacaLog('bios_log_alos');
    }
}
