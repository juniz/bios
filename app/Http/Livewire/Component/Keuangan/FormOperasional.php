<?php

namespace App\Http\Livewire\Component\Keuangan;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\RequestAPI;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Operasional;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FormOperasional extends Component
{
    use RequestAPI, LivewireAlert;
    public $kdbank;
    public $no_rekening;
    public $unit;
    public $saldo_akhir;
    public $tgl_transaksi;

    public function boot()
    {
        $this->resetInput();
    }

    public function render()
    {
        return view('livewire.component.keuangan.form-operasional', [
            'listBank' => DB::table('bios_bank')->get(),
            'listRekening' => DB::table('rekening_rumkit')->get(),
        ]);
    }

    public function resetInput()
    {
        $this->resetExcept('tgl_transaksi', 'unit');
        $this->tgl_transaksi = Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->unit = 'RS BHAYANGKARA NGANJUK';
    }

    public function simpan()
    {
        $this->validate([
            'tgl_transaksi' => 'required|date',
            'kdbank' => 'required',
            'no_rekening' => 'required',
            'unit' => 'required',
            'saldo_akhir' => 'required|numeric',
        ],[
            'tgl_transaksi.required' => 'Tanggal Transaksi tidak boleh kosong.',
            'tgl_transaksi.date' => 'Tanggal Transaksi harus berupa tanggal.',
            'kdbank.required' => 'Kode Bank tidak boleh kosong.',
            'no_rekening.required' => 'No. Rekening tidak boleh kosong.',
            'unit.required' => 'Unit tidak boleh kosong.',
            'saldo_akhir.required' => 'Saldo Akhir tidak boleh kosong.',
            'saldo_akhir.numeric' => 'Saldo Akhir harus berupa angka.',
        ]);

        try{
            $payload = [
                'tgl_transaksi' => $this->tgl_transaksi,
                'kdbank' => $this->kdbank,
                'no_rekening' => $this->no_rekening,
                'unit' => $this->unit,
                'saldo_akhir' => $this->saldo_akhir,
            ];
            $response = $this->sendData('keuangan/saldo/saldo_operasional', $payload);
            if($response->successful()){
                Operasional::updateOrCreate([
                    'tgl_transaksi' => $this->tgl_transaksi,
                    'kdbank' => $this->kdbank,
                    'no_rekening' => $this->no_rekening,
                    'unit' => $this->unit,
                ],[
                    'saldo_akhir' => $this->saldo_akhir,
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
                'text' =>  $response->getBody() ?? 'Terjadi Kesalahan saat kirim data server bios',
                'confirmButtonText' =>  'Oke'
            ]);
        }
    }


}
