<?php

namespace App\Http\Livewire\Component\Ikt\Pobo;

use Livewire\Component;
use App\Models\Pobo;
use Livewire\WithPagination;

class TablePobo extends Component
{
    use WithPagination;
    public $search;
    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];
    protected $listeners = ['refreshTable' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.component.ikt.pobo.table-pobo', [
            'pobos' => Pobo::orderBy('tgl_transaksi', 'desc')->where('tgl_transaksi', 'like', '%'.$this->search.'%')->paginate(10)
        ]);
    }

    public function edit($tgl, $pobo)
    {
        $this->emit('editPobo', $tgl, $pobo);
    }
}
