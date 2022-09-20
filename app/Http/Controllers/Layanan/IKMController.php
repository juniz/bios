<?php

namespace App\Http\Controllers\Layanan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;

class IKMController extends Controller
{
    use Token, RequestAPI, RequestDB;
    public $header, $token, $url, $data, $headTable, $keterangan;

    public function __construct()
    {
        $token = $this->getToken();
        $this->token = $token->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ]; 
        $this->url = 'kesehatan/layanan/ikm_kesehatan';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Nilai Indeks'];
        $this->keterangan = [
            'Data yang dikirimkan merupakan posisi data terakhir pada saat tanggal berkenaan, tidak akumulatif.',
            'Data dikirimkan per periode harian.',
        ];
    }

    public function index()
    {
        return view('layanan.ikm',[
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
