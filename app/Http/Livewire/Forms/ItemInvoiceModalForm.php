<?php

namespace App\Http\Livewire\Forms;

use App\Models\Product;
use Livewire\Component;

class ItemInvoiceModalForm extends Component
{
    public $searchItems = [];
    public $query;

    public function render()
    {
        return view('livewire.forms.item-invoice-modal-form');
    }
    public function updatedQuery()
    {
        // dd($this->searchVendors);
        $this->searchItems = Product::search($this->query)->take(5)->get();
    }

    public function close()
    {
        $this->reset('query','searchItems');
        $this->dispatchBrowserEvent('closeModel');
    }

    public function addItem($id)
    {
        $this->emitTo('forms.invoice-form','selectItem',$id);

        $this->dispatchBrowserEvent('closeModel');
        $this->reset('query','searchItems');
    }
    public function createItem()
    {
        $this->emitTo('forms.invoice-form','createItem');
        $this->dispatchBrowserEvent('closeModel');
        $this->reset('query','searchItems');
    }
}
