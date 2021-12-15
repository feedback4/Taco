<?php

namespace App\Http\Livewire\Forms;

use App\Models\Item;
use App\Models\Product;
use Livewire\Component;

class ProductPriceOfferModalForm extends Component
{


    public $searchProducts = [];
    public $query;

    public function render()
    {
        return view('livewire.forms.product-price-offer-modal-form');
    }
    public function updatedQuery()
    {
        // dd($this->searchVendors);
        $this->searchProducts = Product::search($this->query)->take(5)->get();
    }

    public function close()
    {
        $this->reset('query','searchProducts');
        $this->dispatchBrowserEvent('closeModel');
    }

    public function addProduct($id)
    {
        $this->emitTo('sales.price-offer','selectProduct',$id);

        $this->dispatchBrowserEvent('closeModel');
        $this->reset('query','searchProducts');
    }
}
