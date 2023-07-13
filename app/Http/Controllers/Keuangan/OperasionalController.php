<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use Illuminate\Support\Facades\Cache;


class OperasionalController extends Controller
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
        $this->url = 'keuangan/saldo/saldo_operasional';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'No. Rekening', 'Kd. Bank', 'Unit', 'Saldo',  'Status', 'Send at', 'updated at', 'Aksi'];
        $this->keterangan = [
            'Data yang dikirimkan merupakan posisi data terakhir pada saat tanggal berkenaan, tidak akumulatif.',
            'Data dikirimkan per periode harian.',
        ];
    }

    public function index()
    {
        return view('keuangan.operasional', [
            'data' => $this->data,
            'head' => $this->headTable,
            'bank' => $this->getBank()->json()['data'],
            'rekening' => $this->getRekening(),
            'keterangan' => $this->keterangan,
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        unset($input['_token']);
        $response = $this->postData($this->url, $this->header, $input, 'bios_log_operasional');
        return $response->json();
    }

    public function read()
    {
        return $this->bacaLog('bios_log_operasional');
    }
}
