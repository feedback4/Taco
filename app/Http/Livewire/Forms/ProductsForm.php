<?php

namespace App\Http\Livewire\Forms;

use App\Models\Formula;

use App\Models\Item;
use App\Models\Product;
use Livewire\Component;

class ProductsForm extends Component
{
    protected $rules = [
        'formula_id' => 'required',
        'amount' => 'required',
        'unit' => 'required',
        'invElement.*'  => 'nullable',
    ];
    public $formula_id;
    public $amount = 0;
    public $formula ;
    public $unit;
    public $total = 0;
    public  $invElement  ;
    public  $proElement = [] ;
    public function render()
    {
        return view('livewire.forms.products-form', [
            'units' => Item::$units,
            'formulas' => Formula::with('category')->get(),
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function updatedFormulaId()
    {
        $this->reset('formula') ;
    }

    public function updatedInvElement()
    {
        foreach($this->invElement as $k => $element){
            $this->proElement[$k] =  $element;
        }
      //  dd($this->proElement[1]);

    }

    public function generate()
    {
        $validated = $this->validate();

        if ($this->amount <= 0) {
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Please select amount']);
            return back();
        }
        $this->formula = Formula::whereId($this->formula_id)->with(['elements'=>fn($q)=>$q->with('category')])->first();

     ///   $items = Item::whereHas('category',fn($q)=> $q->where('id',4))->get() ;

    }

    public function save()
    {
        $validated = $this->validate();

        Product::create([
            'formula_id' => $this->formula,
            'amount' => $this->amount,
            'unit' => $this->unit,
            'inventory_id' => 1,
            'user_id' => auth()->id(),
        ]);

        $this->emit('alert',
            ['type' => 'info', 'message' => 'Items Created Successfully!']);
        return redirect()->route('inventory');
    }
}
