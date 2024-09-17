<?php

namespace App\Http\Livewire\Component\Keuangan;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RekeningForm extends Component
{
    use LivewireAlert;
    public $no_rek;
    public $nama;

    public function render()
    {
        return view('livewire.component.keuangan.rekening-form');
    }

    public function store()
    {
        $this->validate([
            'no_rek' => 'required|unique:rekening_rumkit',
            'nama' => 'required',
        ], [
            'no_rek.required' => 'No Rekening tidak boleh kosong',
            'no_rek.unique' => 'No Rekening sudah ada',
            'nama.required' => 'Nama Rekening tidak boleh kosong',
        ]);

        try {

            DB::table('rekening_rumkit')->insert([
                'no_rek' => $this->no_rek,
                'nama' => $this->nama,
            ]);

            $this->reset();
            $this->emit('refreshDatatable');
            $this->alert('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            $this->alert('error', 'Data gagal disimpan : ' . $e->getMessage());
        }
    }
}
