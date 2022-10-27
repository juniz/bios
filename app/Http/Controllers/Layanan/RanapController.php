<?php

namespace App\Http\Controllers\Layanan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Traits\Token;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RanapController extends Controller
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
        $this->url = 'kesehatan/layanan/pasien_ranap';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Kelas', 'Jumlah'];
        $this->tanggal = $request->input('tgl') ?? Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->keterangan = [
            'Data yang dikirimkan merupakan posisi data terakhir pada saat tanggal berkenaan, tidak akumulatif.',
            'Data dikirimkan per periode harian.',
        ];
    }

    public function index()
    {
        return view('layanan.ranap',[
            'data' => $this->data, 
            'head' => $this->headTable, 
            'tanggal' => $this->tanggal,
            'ranap' => $this->counRanap($this->tanggal),
            'keterangan' => $this->keterangan,
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $response = [];
        for($i=0; $i < count($input['kode_kelas']); $i++){
            $layanan = $input['kode_kelas'][$i];
            $jumlah =  $input['jumlah'][$i];
            $body = [
                'tgl_transaksi' => $input['tgl_transaksi'],
                'kode_kelas' => $layanan,
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
    
}
