<?php

namespace App\Http\Controllers\Layanan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Traits\Token;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RalanController extends Controller
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
        $this->url = 'kesehatan/layanan/pasien_ralan';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Jumlah'];
        $this->tanggal = $request->input('tgl') ?? Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->keterangan = [
            'Data yang dikirimkan merupakan posisi data terakhir pada saat tanggal berkenaan, tidak akumulatif.',
            'Data dikirimkan per periode harian.',
        ];
    }

    public function index()
    {
        return view('layanan.ralan',[
            'data' => $this->data, 
            'head' => $this->headTable, 
            'tanggal' => $this->tanggal,
            'jumlah' => $this->countRalan(),
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

    public function countRalan()
    {
       $data = DB::table('reg_periksa')
                    ->where('tgl_registrasi', $this->tanggal)
                    ->where('stts', 'Sudah')
                    ->count();
        return $data;
    }
}
