<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use Illuminate\Support\Facades\Cache;

class PenerimaanController extends Controller
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
        $this->url = 'keuangan/akuntansi/penerimaan';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Kd. Akun', 'Jumlah', 'Status', 'Send at', 'updated at', 'Aksi'];
        $this->keterangan = [
            'Data yang dikirimkan digrouping per tanggal per akun dan posisi data pada saat tanggal berkenaan, bersifat akumulatif.',
            'Data dikirimkan per periode harian atau per terjadinya transaksi. Data yang dikirimkan termasuk yang belum di SP3B/disahkan.'
        ];
    }

    public function index()
    {
        return view('keuangan.penerimaan', [
            'data' => $this->data,
            'head' => $this->headTable,
            'akun' => $this->getAkun()->json()['data'],
            'keterangan' => $this->keterangan,
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        unset($input['_token']);
        $response = $this->postData($this->url, $this->header, $input, 'bios_log_penerimaan');
        return $response->json();
    }

    public function read()
    {
        return $this->bacaLog('bios_log_penerimaan');
    }
}
