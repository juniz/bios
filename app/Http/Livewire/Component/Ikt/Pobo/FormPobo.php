<?php

namespace App\Http\Livewire\Component\Ikt\Pobo;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Pobo;
use Illuminate\Support\Facades\App;
use App\Http\Traits\Telegram;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\Token;

class FormPobo extends Component
{
    use LivewireAlert, Telegram, RequestAPI;
    public $tgl_transaksi, $pobo, $url;

    protected $listeners = ['editPobo' => 'edit'];

    public function mount()
    {
        $this->url = 'kesehatan/ikt/rasio_pobo';
        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.component.ikt.pobo.form-pobo');
    }

    public function resetInput()
    {
        $this->tgl_transaksi = Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->pobo = 0;
    }

    public function edit($tgl, $pobo)
    {
        $this->tgl_transaksi = $tgl;
        $this->pobo = $pobo;
    }

    public function simpan()
    {
        // dd($this->tgl_transaksi);
        $this->validate([
            'tgl_transaksi' => 'required|date',
            'pobo' => 'required|numeric'
        ],[
            'tgl_transaksi.required' => 'Tanggal Transaksi tidak boleh kosong.',
            'tgl_transaksi.date' => 'Tanggal Transaksi harus berupa tanggal.',
            'pobo.required' => 'POBO tidak boleh kosong.',
            'pobo.numeric' => 'POBO harus berupa angka.',
        ]);

        try{
            $payload = [
                'tgl_transaksi' => $this->tgl_transaksi,
                'pobo' => $this->pobo
            ];
            
            $response = $this->sendData($this->url, $payload);

            if($response->successful() && $response->json()['status'] == 'MSG20003'){
                Pobo::updateOrCreate([
                    'tgl_transaksi' => $this->tgl_transaksi
                ],[
                    'pobo' => $this->pobo,
                    'kode' => $response->status(),
                    'status' => $response->json()['status'],
                    'response' => $response->body(),
                ]);

                $this->resetInput();
                $this->emit('refreshTable');
                $this->alert('success', 'Data berhasil disimpan');
            }else{

                $this->alert('error', 'Gagal', [
                    'position' =>  'center',
                    'timer' =>  '',
                    'toast' =>  false,
                    'text' =>  $response->getBody() ?? 'Terjadi Kesalahan saat kirim data server bios',
                    'confirmButtonText' =>  'Oke'
                ]);
            }

        }catch(\Exception $e){

            $this->alert('error', 'Gagal', [
                'position' =>  'center',
                'timer' =>  '',
                'toast' =>  false,
                'text' =>  App::environment('local') ? $e->getMessage() : 'Terjadi Kesalahan',
                'confirmButtonText' =>  'Oke'
            ]);
        }
    }
}
