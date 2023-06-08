<?php

namespace App\Http\Controllers\Layanan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class OperasiController extends Controller
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
        $this->url = 'kesehatan/layanan/operasi';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Klasifikasi', 'Jumlah', 'Status', 'Send at', 'Updated at', 'Aksi'];
        $this->tanggal = $request->input('tgl') ?? Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->keterangan = [
            'Data yang dikirimkan merupakan posisi data terakhir pada saat tanggal berkenaan, tidak akumulatif.',
            'Data dikirimkan per periode harian.',
        ];
    }

    public function index()
    {
        return view('layanan.operasi',[
            'data' => $this->data, 
            'head' => $this->headTable, 
            'tanggal' => $this->tanggal,
            'operasi' => $this->countOperasi($this->tanggal),
            'keterangan' => $this->keterangan,
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $response = [];
        unset($input['_token']);
        if(is_array($input['klasifikasi_operasi'])){
            for($i=0; $i < count($input['klasifikasi_operasi']); $i++){
                $layanan = $input['klasifikasi_operasi'][$i];
                $jumlah =  $input['jumlah'][$i];
                $body = [
                    'tgl_transaksi' => $input['tgl_transaksi'],
                    'klasifikasi_operasi' => $layanan,
                    'jumlah' => $jumlah,
                ];
                $response = $this->postData($this->url, $this->header, $body, 'bios_log_operasi');
                if($response->json()['status'] != 'MSG20003'){
                    return $response->json();
                }
            }
        }else{
            $response = $this->postData($this->url, $this->header, $input, 'bios_log_operasi');
        }
        
        return $response->json();
    }

    public function read()
    {
        return $this->bacaLog('bios_log_operasi');
    }
}
