<?php

namespace App\Http\Livewire\Tables;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryTable extends Component
{
    use WithPagination;
    protected $listeners = ['refreshElements' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    public function render()
    {
        return view('livewire.tables.inventory-table',[
            'items' =>Item::search($this->search)
            ->whereHas('inventory' ,function($q){
                $q->where('id',1);
            })->with('element')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage)
        ]);
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
}
