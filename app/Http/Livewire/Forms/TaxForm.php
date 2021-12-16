<?php

namespace App\Http\Livewire\Forms;

use App\Models\Tax;
use Livewire\Component;

class TaxForm extends Component
{
    protected $listeners = ['editTax' => 'edit' ];
    protected $rules = [
        'name' => 'required',
        'percent' => 'required|numeric|gt:0',
    ];

    public $name ;
    public $percent ;


    public $tax;

    public $title = 'create' ;
    public $button = 'create' ;
    public $color = 'success';


    public function render()
    {
        $taxes = Tax::all();
        return view('livewire.forms.tax-form',compact('taxes'));
    }

    public  function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public  function save()
    {
        $validated =  $this->validate();

        if ($this->tax){
            $this->tax->update($validated);
            $this->emit('alert',
                ['type' => 'info',  'message' => 'Tax Updated Successfully!']);
        }else{
//            if (Element::where('name',$this->name)->exists()){
//                $this->emit('alert',
//                    ['type' => 'info',  'message' => 'The name has already been taken.']);
//                return back();
//            }
            $tax =  Tax::create($validated);
            $this->emit('alert',
                ['type' => 'success',  'message' => 'Element Created Successfully!']);
        }
        $this->emitTo('tables.taxes-table','refreshTaxes');
        $this->reset();

        return back();
    }


    public function edit(int $taxId)
    {
        // dd($locationId);
        $this->tax = Tax::where('id', $taxId)->first();

        $this->name = $this->tax->name;
        $this->percent = $this->tax->percent;



        $this->title = 'edit';
        $this->button = 'update';
        $this->color = 'primary';
    }
}
