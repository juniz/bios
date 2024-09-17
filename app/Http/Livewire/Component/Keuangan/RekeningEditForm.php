<?php

namespace App\Http\Livewire\Component\Keuangan;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RekeningEditForm extends Component
{
    use LivewireAlert;
    public $no_rek;
    public $nama;
    protected $listeners = ['openRekeningEditForm' => 'open'];

    public function render()
    {
        return view('livewire.component.keuangan.rekening-edit-form');
    }

    public function open($no_rek)
    {
        $rekening = DB::table('rekening_rumkit')->where('no_rek', $no_rek)->first();
        // dd($rekening);
        $this->no_rek = $rekening->no_rek;
        $this->nama = $rekening->nama;
        $this->emit('openModalRekeningEdit');
    }

    public function edit()
    {
        $this->validate([
            'no_rek' => 'required',
            'nama' => 'required',
        ], [
            'no_rek.required' => 'No Rekening tidak boleh kosong',
            'nama.required' => 'Nama Rekening tidak boleh kosong',
        ]);

        try {

            DB::table('rekening_rumkit')->where('no_rek', $this->no_rek)->update([
                'nama' => $this->nama,
            ]);

            $this->reset();
            $this->emit('refreshDatatable');
            $this->emit('closeModalRekeningEdit');
            $this->alert('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            $this->alert('error', 'Data gagal diubah : ' . $e->getMessage());
        }
    }
}
