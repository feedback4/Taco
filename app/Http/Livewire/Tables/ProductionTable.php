<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProductionOrder;
use Livewire\Component;
use Livewire\WithPagination;

class ProductionTable extends Component
{
    use WithPagination;
    protected $listeners = ['refreshProduction' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderDesc = true;
    public $inventoryId  ;

    public function render()
    {
        return view('livewire.tables.production-table',[
            'productionOrders' =>ProductionOrder::search($this->search)
//                ->whereHas('inventory' ,function($q){
//                    $q->where('id', $this->inventoryId);
//                })
                ->with('items','formula','user')
                ->orderBy($this->orderBy, $this->orderDesc ? 'desc' : 'asc')
                ->paginate($this->perPage)
        ]);
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

}
