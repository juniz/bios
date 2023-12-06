<?php

namespace App\Http\Livewire\Component\Renstra;

use Livewire\Component;

class ChartHead extends Component
{
    public $name;

    public function mount($name)
    {
        $this->name = $name;
    }
    
    public function render()
    {
        return view('livewire.component.renstra.chart-head');
    }
}
