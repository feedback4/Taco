<?php

namespace App\Http\Livewire\Forms;

use App\Models\Formula;

use App\Models\Item;
use App\Models\Product;
use App\Models\ProductionOrder;
use Livewire\Component;

class ProductionForm extends Component
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
        return view('livewire.forms.production-form', [
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
        $this->reset('formula','invElement','proElement') ;
    }

    public function updatedInvElement()
    {
        foreach($this->invElement as $k => $element){
            foreach($element as $key => $index){
                $amount = Item::whereId($key)->pluck('amount')->first() ;
                if($amount < $index){
                    $element[$key] = $amount ;
                    $this->invElement[$k][$key] = $amount;
                    $this->emit('alert',
                        ['type' => 'info', 'message' => 'يا جدع مينفعش']);
                }
            }
            $this->proElement[$k] =  $element;
        }
    }

    public function generate()
    {
        $validated = $this->validate();

        if ($this->amount <= 0) {
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Amount can\'t be zero']);
            return back();
        }
        $this->formula = Formula::whereId($this->formula_id)->with(['elements'=>fn($q)=>$q->with('category')])->first();

     ///   $items = Item::whereHas('category',fn($q)=> $q->where('id',4))->get() ;

    }

    public function save()
    {
        $validated = $this->validate();
        if (!$this->invElement){
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Please insert amount first']);
            return ;
        }
        if( count($this->invElement) < count($this->formula->elements) ){
            $this->emit('alert',
                ['type' => 'error', 'message' =>  'All Elements aren\'t present']);
            return ;
        }

        $order = ProductionOrder::create([
            'formula_id' => $this->formula->id,
            'amount' => $this->amount,
    //        'unit' => $this->unit,
            'user_id' => auth()->id(),
        ]);

   foreach ($this->invElement as $k => $ele) {
       foreach ($ele as $key => $index){
           if ($index > 0){
               $order->items()->attach($key, ['amount' => floatval($index)]);
           }
       }
   }
        $this->emit('alert',
            ['type' => 'info', 'message' => 'Production Order Created Successfully!']);
        return redirect()->route('production');
    }
}
