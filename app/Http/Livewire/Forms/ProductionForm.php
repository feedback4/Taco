<?php

namespace App\Http\Livewire\Forms;

use App\Models\Element;
use App\Models\Formula;

use App\Models\Item;
use App\Models\Product;
use App\Models\ProductionOrder;
use Livewire\Component;

class ProductionForm extends Component
{
    protected $rules = [
        'formula_id' => 'required|exists:formulas,id',
        'amount' => 'required',
        'times' => 'required',
        'ready' => 'nullable',
        'invElement.*'  => 'nullable',
    ];
    public $formula_id;
    public $amount = 0;
    public $formula ;
    public $times;
    public $total = 0;
    public  $invElement  ;
    public  $proElement = [] ;
    public  $ready = []  ;
    public  $items = []  ;
    public $cost = 0 ;
    public $number ;

    public $productionOrder ;

    public function mount($productionOrder = null)
    {
        if ($productionOrder){
            $this->productionOrder = $productionOrder ;
            $this->formula_id =  $this->productionOrder->formula_id;
            $this->amount =  $this->productionOrder->amount;
            $this->times =  $this->productionOrder->times;
            $this->generate();
      //      $this->formula = Formula::find($this->productionOrder->formula_id);

            foreach ( $this->productionOrder->items as $item ){

                $this->invElement[$item->element_id] = [$item->id => $item->pivot->amount];
            }
            $this->updatedInvElement();
        }else{
            $latest = ProductionOrder::latest()->first()->id ?? 0;
            $this->number = 'order-' . (str_pad((int)$latest + 1, 5, '0', STR_PAD_LEFT));
        }


    }
    public function render()
    {
        return view('livewire.forms.production-form', [
            'units' => Item::$units,
            'formulas' => Formula::whereHas('product')->with('category')->get(),
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function updatedFormulaId()
    {
        $this->reset('formula','invElement','proElement','ready') ;
    }

    public function updatedInvElement()
    {
        $this->cost = 0 ;
        foreach($this->invElement as $k => $element){
            foreach($element as $key => $index){
                $item = Item::whereId($key)->first() ;
                if($item->quantity  < $index){
                    $element[$key] = $item->quantity  ;
                    $this->invElement[$k][$key] = $item->quantity ;
                    $this->emit('alert',
                        ['type' => 'info', 'message' => 'يا جدع مينفعش']);
                }elseif(!$index){
                    $element[$key] = 0 ;
                    $this->invElement[$k][$key] =0;
                }

                $this->cost += $index * $item->price ;
            }
            $this->proElement[$k] =  $element;
        }
    }
    private function cal()
    {
        if ($this->invElement){
            foreach($this->invElement as $k => $element){
                $sum = array_sum($this->proElement[$k]) ;
                $elem = Element::whereId($k)->with('formulas')->first();
                $percent =  $elem->formulas()->first()->pivot->amount;
                if(isset($this->ready[$k])){
                    if(  !$this->ready[$k] && ($percent * $this->amount /100) > $sum ){
                        return false ;
                    }
                }
            }
        }
        return true ;
    }

    public function generate()
    {
        $validated = $this->validate();

        if ($this->amount <= 0) {
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Amount can\'t be zero']);
            return back();
        }
        $this->formula = Formula::whereId($this->formula_id)->with(['elements'=>fn($q)=>$q->select('elements.id','elements.name','elements.code')])->first();

        if($this->formula){
            foreach ($this->formula->elements as  $element){
                $this->ready[$element->id] = false;
            // $this->items[$element->id] =  Item::whereHas('inventory')->where('type','material')->where('element_id',$element->id)->with('element')->get();
            }
        }
    }

    public function save()
    {
        $validated = $this->validate();

//        if (!$this->invElement){
//            $this->emit('alert',
//                ['type' => 'error', 'message' => 'Please insert amount first']);
//            $this->emit('alert',
//                ['type' => 'warning', 'message' => 'Product will be generated with 0 cost ']);
//            return ;
//        }

//        if( count($this->invElement) < count($this->formula->elements) ){
//            $this->emit('alert',
//                ['type' => 'error', 'message' =>  'All Elements aren\'t present']);
//            return ;
//        }

        if (!$this->cal()){
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Some items are missing']);
            return ;
        }

        if ($this->productionOrder){

            $this->productionOrder->update([
                'formula_id' => $this->formula->id,
                'amount' => floatval($this->amount),
                'times' => $this->times,
                'user_id' => auth()->id(),
            ]);



            $this->emit('alert',
                ['type' => 'info', 'message' => 'Production Order Updated Successfully!']);

        }else{
            $order = ProductionOrder::create([
                'number' => $this->number,
                'formula_id' => $this->formula->id,
                'amount' => floatval($this->amount),
                'times' => $this->times,
                'user_id' => auth()->id(),
            ]);


            foreach ($this->formula->elements as $element){
                if($this->ready[$element->id] ) {
                    if(isset($this->invElement[$element->id])) {
                        foreach ($this->invElement[$element->id] as $key => $index){
                            if ($index > 0) {
                                $order->items()->attach($key, ['amount' => floatval($index) ]);
                            }
                        }
                    }
                }else{
                    if(isset($this->invElement[$element->id])) {
                        foreach ($this->invElement[$element->id] as $key => $index){
                            $index = (float) $index;
                            if ($index > 0){
                                $order->items()->attach($key, ['amount' => floatval($index)]);
                            }
                        }
                    }
                }
            }
            $this->emit('alert',
                ['type' => 'info', 'message' => 'Production Order Created Successfully!']);
        }




        return redirect()->route('production.index');
    }
}
