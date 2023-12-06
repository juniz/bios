<?php

namespace App\Http\Livewire\Component\Keuangan;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\RequestAPI;

class FormOperasional extends Component
{
    use RequestAPI;
    public $loadBank = false;
    public $bank, $no_rekening;

    public function mount()
    {
        $this->bank = [];
    }
    public function render()
    {
        return view('livewire.component.keuangan.form-operasional');
    }

    public function readyLoadBank()
    {
        $this->loadBank = true;
    }

    public function bankUpdated()
    {
        $this->bank = $this->getBank()->json()['data'];
        $this->emit('bankUpdated', $this->bank);
    }
}
