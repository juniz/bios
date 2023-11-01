<?php

namespace App\Http\Livewire\Component\Sdm;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\RequestAPI;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Table extends Component
{
    use WithPagination, RequestAPI, LivewireAlert;
    public $table, $url, $headers;
    public $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['load' => '$refresh'];

    public function mount($table, $url)
    {
        $this->table = $table;
        $this->url = $url;
        $this->headers = [
            'token' => '',
            'Content-Type' => 'multipart/form-data'
        ];
    }

    public function load()
    {
        $this->readyToLoad = true;
        $this->headers['token'] = Cache::get('token') ?? $this->getToken()->json()['token'];
    }

    public function render()
    {
        return view('livewire.component.sdm.table', [
            'datas' => $this->readyToLoad ? DB::table($this->table)->orderByDesc('tgl_transaksi')->paginate(10) : [],
        ]);
    }

    public function kirim($tgl, $pns, $pppk, $anggota, $non_pns_tetap, $kontrak)
    {
        if($this->table == 'bios_log_administrasi'){
            $input = [
                'tgl_transaksi' => $tgl,
                'pns' => $pns,
                'pppk' => $pppk,
                'anggota' => $anggota,
                'non_pns_tetap' => $non_pns_tetap,
                'kontrak' => $kontrak,
                'keterangan' => 'Umum, Keuangan, SDM, Humas, BMN',
            ];
        }else{
            $input = [
                'tgl_transaksi' => $tgl,
                'pns' => $pns,
                'pppk' => $pppk,
                'anggota' => $anggota,
                'non_pns_tetap' => $non_pns_tetap,
                'kontrak' => $kontrak,
            ];
        }
        $response = $this->postDataSDM($this->url, $this->headers, $input, $this->table);
        if ($response->json()['status'] == 'MSG20003') {
            $this->emit('load');
            $this->alert('success', 'Data berhasil dikirim ke server bios');
        } else {
            $this->alert('warning', 'Data gagal dikirim ke server bios');
        }
    }
}
