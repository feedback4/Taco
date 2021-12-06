<?php

namespace App\Http\Livewire\Forms;

use App\Models\Vendor;
use Livewire\Component;

class VendorModalForm extends Component
{
    protected $rules = [
        'name' => 'required',
        'phone' => 'required',
        'email' => 'nullable',
        'address' => 'required',
    ];

    public $name ;
    public $phone ;
    public $email ;
    public $address;
    public $vendor;

    public $updateMode = false;

    public function render()
    {
        return view('livewire.forms.vendor-modal-form');
    }

    public  function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function open()
    {
        $this->updateMode = true;
    }
    public function close()
    {
        $this->updateMode = false;
        $this->dispatchBrowserEvent('closeModel');
    }

    public function save()
    {
        $validated =  $this->validate();
      $this->vendor =   Vendor::create($validated);
        $this->emitTo('forms.bill-form','selectVendor',$this->vendor->id);
        $this->dispatchBrowserEvent('closeModel');
    }
}
