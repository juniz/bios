<?php

namespace App\Http\Controllers\Keuangan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;

class KasController extends Controller
{
    use Token, RequestAPI, RequestDB;
    public $header, $token, $url, $data, $headTable;

    public function __construct()
    {
        $token = $this->getToken();
        $this->token = $token->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ];
        $this->url = 'keuangan/saldo/saldo_pengelolaan_kas';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'No. Bilyet', 'Nilai Bunga', 'Nilai Deposito'];
    }

    public function index()
    {
        return view('keuangan.kas',[
            'data' => $this->data, 
            'head' => $this->headTable, 
            'bank' => $this->getBank()->json()['data'],
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
