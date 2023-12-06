<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TableData extends Component
{
    use WithPagination, LivewireAlert;
    public $database, $readyToLoad = false;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshTable' => '$refresh'];

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

    public function eksekusi($job)
    {
        Artisan::call($job);
        $this->alert('success', 'Data berhasil di eksekusi');
        $this->emit('refreshTable');
    }
}
