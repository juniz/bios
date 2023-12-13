<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use App\Models\Kelolaan;
use App\Models\Operasional;
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
        // $response = $this->postData($this->url, $this->header, $input, 'bios_log_operasional');
        try{

            $response = $this->sendData($this->url, $input);
            Operasional::updateOrCreate([
                'tgl_transaksi' => $input['tgl_transaksi'],
                'no_rekening' => $input['no_rekening'],
                'kdbank' => $input['kdbank'],
                'unit' => $input['unit'],
            ],[
                'saldo_akhir' => $input['saldo_akhir'],
                'kode' => $response->status() ?? 408,
                'status' => $response->json()['status'] ?? 'MSG50000',
                'response' => $response->body() ?? 'Terjadi kesalahan saat akses server bios',
            ]);
            return $response->json();

        }catch(\Exception $e){

            return response()->json([
                'status' => 'MSG50000',
                'message' => $e->getMessage()
            ], 500);
            
        }
    }

    public function read()
    {
        return $this->bacaLog('bios_log_operasional');
    }

    public function simpan(Request $request)
    {
        try{

            foreach($request->all() as $r){
                $input = [
                    'tgl_transaksi' => $r['tgl_transaksi'],
                    'no_rekening' => $r['no_rekening'],
                    'kdbank' => $r['kdbank'],
                    'saldo_akhir' => $r['saldo_akhir'],
                    'kode' => 200,
                    'status' => 'MSG20003',
                    'response' => ''
                ];

                Kelolaan::create($input);
            }

            return response()->json([
                'status' => 'MSG20003',
                'message' => 'Data berhasil disimpan'
            ], 200);

        }catch(\Exception $e){
            return response()->json([
                'status' => 'MSG50000',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
