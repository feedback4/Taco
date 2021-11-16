<?php

namespace App\Http\Livewire\Tables;

use App\Exports\InventoryExpoter;
use App\Models\Inventory;
use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class InventoryTable extends Component
{
    use WithPagination;
    protected $listeners = ['refreshElements' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    public $perPage = 50;
    public $search = '';
    public $orderBy = 'id';
    public $orderDesc = true;
    public $inventoryId  ;

    public function mount()
    {
        $this->inventoryId = 1;
    }

    public function render()
    {
        return view('livewire.tables.inventory-table',[
            'items' =>Item::search($this->search)
            ->whereHas('inventory' ,function($q){
                $q->where('id', $this->inventoryId);
            })->with('element')
            ->orderBy($this->orderBy, $this->orderDesc ? 'desc' : 'asc')
            ->paginate($this->perPage)
        ]);
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
    public function export()
    {
     //   dd($this->inventoryId);
        $name  = Inventory::whereId($this->inventoryId)->pluck('name')->first();
        $items = Item::search($this->search)
            ->whereHas('inventory' ,function($q){
                $q->where('id', $this->inventoryId);
            })->with('element')
            ->orderBy($this->orderBy, $this->orderDesc ? 'desc' : 'asc')
            ->pluck('id');
        return Excel::download(new InventoryExpoter($items),'Inventory '.$name.'.csv');
    }
}
