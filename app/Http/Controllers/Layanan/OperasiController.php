<?php

namespace App\Http\Controllers\Layanan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OperasiController extends Controller
{
    use Token, RequestAPI, RequestDB;
    public $header, $token, $url, $data, $headTable, $tanggal, $keterangan;

    public function __construct(Request $request)
    {
        $token = $this->getToken();
        $this->token = $token->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ];
        $this->url = 'kesehatan/layanan/operasi';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Klasifikasi Operasi', 'Jumlah'];
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
        for($i=0; $i < count($input['klasifikasi_operasi']); $i++){
            $layanan = $input['klasifikasi_operasi'][$i];
            $jumlah =  $input['jumlah'][$i];
            $body = [
                'tgl_transaksi' => $input['tgl_transaksi'],
                'klasifikasi_operasi' => $layanan,
                'jumlah' => $jumlah,
            ];
            $response = $this->postData($this->url, $this->header, $body);
            if($response->json()['status'] != 'MSG20003'){
                return $response->json();
            }
        }
        
        return $response->json();
    }

    public function read()
    {
        $response = $this->getData($this->url, $this->header);
        return $response->json();
    }

    // public function countOperasi()
    // {
    //     $data = DB::table('operasi')
    //                 ->where('tgl_operasi', 'like', $this->tanggal.'%')
    //                 ->groupBy('kategori')
    //                 ->selectRaw("kategori, count(no_rawat) as jml")
    //                 ->get();
    //     return $data;
    // }
}
