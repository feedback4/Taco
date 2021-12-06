<?php

namespace App\Http\Livewire\Forms;

use App\Models\Element;
use App\Models\Item;
use App\Models\Vendor;
use Livewire\Component;

class ItemBillModalForm extends Component
{
    public $searchItems = [];
    public $query;

    public function render()
    {
        return view('livewire.forms.item-bill-modal-form');
    }
    public function updatedQuery()
    {
        // dd($this->searchVendors);
        $this->searchItems = Element::search($this->query)->take(5)->get();
    }

    public function close()
    {
        $this->reset('query','searchItems');
        $this->dispatchBrowserEvent('closeModel');
    }

    public function addItem($id)
    {
        $this->emitTo('forms.bill-form','selectItem',$id);

        $this->dispatchBrowserEvent('closeModel');
        $this->reset('query','searchItems');
    }
    public function createItem()
    {
        $this->emitTo('forms.bill-form','createItem');
        $this->dispatchBrowserEvent('closeModel');
        $this->reset('query','searchItems');
    }
}
