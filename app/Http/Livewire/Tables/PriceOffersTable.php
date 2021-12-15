<?php

namespace App\Http\Livewire\Tables;

use App\Http\Livewire\Sales\PriceOffer;
use App\Models\ProductionOrder;
use Livewire\Component;
use Livewire\WithPagination;

class PriceOffersTable extends Component
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
        return view('livewire.tables.price-offers-table',[
            'priceOffers' =>  \App\Models\PriceOffer::search($this->search)
                ->with('products','client','user')
                ->orderBy($this->orderBy, $this->orderDesc ? 'desc' : 'asc')
                ->paginate($this->perPage)
        ]);
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

}
