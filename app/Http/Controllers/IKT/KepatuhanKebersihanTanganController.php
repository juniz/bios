<?php

namespace App\Http\Controllers\IKT;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use Illuminate\Support\Facades\Cache;

class KepatuhanKebersihanTanganController extends Controller
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
        $this->url = 'kesehatan/ikt/kepatuhan_kebersihan_tangan';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Jumlah'];
        $this->keterangan = [
            'Data yang dikirimkan merupakan posisi data pada saat tanggal berkenaan, tidak bersifat akumulatif.',
            'Data dikirimkan per periode semesteran.'
        ];
    }

    public function index()
    {
        return view('ikt.kepatuhan-kebersihan-tangan',[
            'data' => $this->data, 
            'head' => $this->headTable, 
            'keterangan' => $this->keterangan,
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $response = $this->postData($this->url, $this->header, $input);
        return $response->json();
    }

    public function read()
    {
        $response = $this->getData($this->url, $this->header);
        return $response->json();
    }
}
