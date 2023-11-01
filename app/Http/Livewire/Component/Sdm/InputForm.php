<?php

namespace App\Http\Livewire\Component\Sdm;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Http\Traits\Token;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Js;

class InputForm extends Component
{
    use LivewireAlert, Token, RequestAPI, RequestDB;
    public $pns, $p3k, $anggota, $non_pns, $kontrak, $tgl_transaksi;
    public $url, $log, $bidang, $headers;

    protected $rules = [
        'pns' => 'required|numeric',
        'p3k' => 'required|numeric',
        'anggota' => 'required|numeric',
        'non_pns' => 'required|numeric',
        'kontrak' => 'required|numeric',
        'tgl_transaksi' => 'required|date',
    ];

    protected $messages = [
        'pns.required' => 'PNS tidak boleh kosong.',
        'p3k.required' => 'P3K tidak boleh kosong.',
        'anggota.required' => 'Anggota tidak boleh kosong.',
        'non_pns.required' => 'Non PNS tidak boleh kosong.',
        'kontrak.required' => 'Kontrak tidak boleh kosong.',
        'tgl_transaksi.required' => 'Tanggal Transaksi tidak boleh kosong.',
        'tgl_transaksi.date' => 'Tanggal Transaksi harus berupa tanggal.',
    ];

    public function mount($url, $log, $bidang)
    {
        $this->url = $url;
        $this->log = $log;
        $this->bidang = $bidang;

        $this->pns = 0;
        $this->p3k = 0;
        $this->anggota = 0;
        $this->non_pns = 0;
        $this->kontrak = 0;
        $this->tgl_transaksi = Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');

        $this->headers = [
            'token' => '',
            'Content-Type' => 'multipart/form-data'
        ];
    }

    public function render()
    {
        return view('livewire.component.sdm.input-form');
    }

    public function init()
    {
        $this->pns = $this->pns($this->bidang);
        $this->p3k = $this->p3k($this->bidang);
        $this->anggota = $this->anggota($this->bidang);
        $this->non_pns = $this->nonPNS($this->bidang);
        $this->kontrak = $this->kontrak($this->bidang);

        $this->headers['token'] = Cache::get('token') ?? $this->getToken()->json()['token'];
    }

    public function simpan()
    {
        $this->validate();

        if($this->bidang =='TENAGA NON MEDIS ADMINISTRASI'){
            $data = [
                'pns' => $this->pns,
                'pppk' => $this->p3k,
                'anggota' => $this->anggota,
                'non_pns_tetap' => $this->non_pns,
                'kontrak' => $this->kontrak,
                'tgl_transaksi' => $this->tgl_transaksi,
                'keterangan' => 'Umum, Keuangan, SDM, Humas, BMN',
            ];
        }else{
            $data = [
                'pns' => $this->pns,
                'pppk' => $this->p3k,
                'anggota' => $this->anggota,
                'non_pns_tetap' => $this->non_pns,
                'kontrak' => $this->kontrak,
                'tgl_transaksi' => $this->tgl_transaksi,
            ];
        }

        $response = $this->postData($this->url, $this->headers, $data, $this->log);

        if ($response->json()['status'] == 'MSG20003') {
            $this->alert('success', 'Data berhasil disimpan');
        } else {
            $this->alert('error', $response->json()['message'] ?? 'Data gagal disimpan', [
                'position' =>  'center',
                'toast' =>  false,
                'text' =>   json_encode($response->json()['error']),
                'confirmButtonText' =>  'Tutup',
                'cancelButtonText' =>  'Batalkan',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  true,
            ]);
        }
        $this->emit('load');
    }
}
