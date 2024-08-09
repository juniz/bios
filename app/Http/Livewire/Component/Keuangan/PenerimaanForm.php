<?php

namespace App\Http\Livewire\Component\Keuangan;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use App\Http\Traits\RequestAPI;
use App\Models\Penerimaan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Carbon;

class PenerimaanForm extends Component
{
    use LivewireAlert, RequestAPI;
    public $tgl_transaksi;
    public $kode_akun;
    public $jumlah;

    public function boot()
    {
        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.component.keuangan.penerimaan-form',[
            'listAkun' => \App\Models\Akun::where('kode', 'like', '4%')->get(),
        ]);
    }

    public function resetInput()
    {
        $this->resetExcept('tgl_transaksi');
        $this->tgl_transaksi = Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
    }

    public function simpan()
    {
        $this->validate([
            'tgl_transaksi' => 'required|date',
            'kode_akun' => 'required',
            'jumlah' => 'required|numeric',
        ],[
            'tgl_transaksi.required' => 'Tanggal Transaksi tidak boleh kosong.',
            'tgl_transaksi.date' => 'Tanggal Transaksi harus berupa tanggal.',
            'kode_akun.required' => 'Akun tidak boleh kosong.',
            'jumlah.required' => 'Jumlah tidak boleh kosong.',
            'jumlah.numeric' => 'Jumlah harus berupa angka.',
        ]);

        $payload = [
            'tgl_transaksi' => $this->tgl_transaksi,
            'kode_akun' => $this->kode_akun,
            'jumlah' => $this->jumlah,
        ];

        // dd($payload);

        try{

            $response = $this->sendData('keuangan/akuntansi/penerimaan', $payload);
            if($response->successful()){
                Penerimaan::updateOrCreate([
                    'tgl_transaksi' => $this->tgl_transaksi,
                    'kode_akun' => $this->kode_akun,
                ],[
                    'jumlah' => $this->jumlah,
                    'kode' => $response->status(),
                    'status' => $response->json()['status'] ?? 'MSG50000',
                    'response' => $response->body() ?? 'Terjadi kesalahan saat akses server bios',
                ]);
            }

            $this->resetInput();
            $this->emit('refreshDatatable');
            $this->alert('success', 'Data berhasil disimpan');
            
        }catch(\Exception $e){
            $this->alert('error', 'Gagal', [
                'position' =>  'center',
                'timer' =>  '',
                'toast' =>  false,
                'text' =>  App::environment('local') ? $e->getMessage() : 'Terjadi Kesalahan saat kirim data server bios',
                'confirmButtonText' =>  'Oke'
            ]);
        }
    }
}
