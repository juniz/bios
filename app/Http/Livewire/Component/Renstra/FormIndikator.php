<?php

namespace App\Http\Livewire\Component\Renstra;

use Livewire\Component;
use App\Models\RenstraIndikator;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FormIndikator extends Component
{
    use LivewireAlert;
    public $indikator;
    public function render()
    {
        return view('livewire.component.renstra.form-indikator');
    }

    public function simpan()
    {
        $this->validate([
            'indikator' => 'required'
        ]);

        RenstraIndikator::create([
            'indikator' => $this->indikator,
            'status' => '1'
        ]);

        $this->alert('success', 'Data berhasil disimpan');
        $this->emit('refreshTable');
        $this->reset();
    }
}
