<?php

namespace App\Http\Livewire\Forms;

use App\Models\Item;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class DoneForm extends Component
{
    use AuthorizesRequests;
    protected $rules = [
        'quantity' => 'required',
        'price' => 'required|numeric|gt:0',
        'description' => 'nullable',

        'working_hours' => 'nullable|numeric|min:0',
        'workers' => 'nullable|numeric|min:1',
    ];
    public $productionOrder ;
    public $cost = 0 ;
    public $expected_amount = 0 ;
    public $expected_price = 0 ;
    public $perHour = 0 ;

    public $quantity =0 ;
    public $price = 0;
    public $description;
    public $working_hours = 0;

    public $loses = 0;
    public $cost_per_unit =0;
    public $profit =0;
    public $hourCost = 0;
    public $totalCost  = 0 ;
    public $workers = 1 ;


    public function mount($productionOrder = null)
    {
//        $this->perHour = setting('per_hour') ?? 0;
//        $salaries = \App\Models\Employee::sum('salary');
//        $perHour = (float)  number_format($salaries /  (setting('working_days') * setting('working_hours')) , 2)  ;
//        $this->perHour =    $perHour ;

        $perHour = (float)  number_format( setting('avg_salary') /  (setting('working_days') * setting('working_hours')) , 2) ;
        $this->perHour =    $perHour ;

        if ($productionOrder){
            $productionOrder = $this->productionOrder;

        foreach ($productionOrder->items as $item){
            $this->cost +=  $item->pivot->amount * $item->price;
        }
        $this->expected_amount = $this->productionOrder->amount - ($this->productionOrder->amount *.05);
        $this->expected_price =  (float)  $this->cost /   $this->expected_amount;
        }
    }
    public function render()
    {
        return view('livewire.forms.done-form');
    }
    public function updatedQuantity()
    {
           $this->cal();
    }
    public function updatedWorkingHours()
    {
     $this->sum();
    }
    public function updatedWorkers()
    {
        $this->sum();
    }
    private function sum()
    {
        if($this->working_hours && $this->workers){
           // $salaries =  array_sum(\App\Models\Employee::pluck('salary')->toArray());
            $perHour = (float)  number_format( (setting('avg_salary') * $this->workers ) /  (setting('working_days') * setting('working_hours')) , 2)  ;
            $this->hourCost = $this->working_hours * $perHour;
            $this->perHour =    $this->hourCost / $this->working_hours ;
            $this->cal();
        }else{
            $this->hourCost  = 0 ;
        }
    }
    private function cal()
    {
        if ($this->quantity){
            $this->loses = (float) ($this->productionOrder->amount - $this->quantity ) * 100 / $this->productionOrder->amount ;
            $this->totalCost = $this->cost + $this->hourCost;
            $this->cost_per_unit = number_format($this->totalCost / $this->quantity ,2 ) +0 ;
        }else{
            $this->quantity=  0  ;
            $this->loses=  0  ;
            $this->cost_per_unit = 0 ;
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function finish()
    {
        $validated = $this->validate();

        $this->cal();

        $this->productionOrder->done_at = now();
        $this->productionOrder->save();

       foreach ($this->productionOrder->items as $item ) {
           $item->quantity = $item->quantity - $item->pivot->amount  ;
           if ($item->quantity== 0){
               $item->delete();
           }else{
               $item->save();
           }
       }


        Item::create([
            'name' => $this->productionOrder->formula->product->name,
            'product_id' => $this->productionOrder->formula->product->id,
            'quantity' =>    $validated['quantity'],
            'description' => $validated['description'], null,
            'cost' => $this->cost_per_unit,
            'price' =>   $validated['price'],
            'user_id' => auth()->id() ,
            'production_order_id' =>  $this->productionOrder->id ,
            'type' => 'product',

        ]);


        return redirect()->route('inventory.products.pending');
    }
}
