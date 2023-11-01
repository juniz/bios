<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class TableData extends Component
{
    use WithPagination;
    public $database, $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';

    public function mount($database)
    {
        $this->database = $database;
    }

    public function load()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.component.table-data', [
            'datas' => $this->readyToLoad ? DB::table($this->database)->latest()->paginate(10) : [],
        ]);
    }
}
