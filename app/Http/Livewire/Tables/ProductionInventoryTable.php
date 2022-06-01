<?php

namespace App\Http\Livewire\Tables;

use App\Exports\InventoryExpoter;
use App\Exports\ProductionInventoryExporter;
use App\Exports\ProductsInventoryExporter;
use App\Models\Inventory;
use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ProductionInventoryTable extends Component
{
    use WithPagination;
    protected $listeners = ['refreshElements' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    public $perPage = 50;
    public $search = '';
    public $orderBy = 'id';
    public $orderDesc = true;
    public $inventoryId  ;

    public function mount($inventoryId)
    {
        $this->inventoryId = $inventoryId;
    }

    public function render()
    {
        return view('livewire.tables.production-inventory-table',[
            'items' =>Item::search($this->search)
                ->whereHas('inventory' ,function($q){
                    $q->where('id', $this->inventoryId);
                })->with(['element','product'])
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
            })->with(['element','product'])
            ->orderBy($this->orderBy, $this->orderDesc ? 'desc' : 'asc')
            ->pluck('id');
        if ($name == 'production'){
            return Excel::download(new ProductionInventoryExporter($items),'Inventory '.$name.'.xlsx');
        }
       // return Excel::download(new ProductsInventoryExporter($items),'Inventory '.$name.'.xlsx');
    }
}
