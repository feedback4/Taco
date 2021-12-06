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


    public function mount($productionOrder = null)
    {
        $productionOrder = $this->productionOrder;

        $this->perHour = setting('per_hour') ?? 0;
        $salaries = \App\Models\Employee::sum('salary');
        $perHour = (float)  number_format($salaries /  (setting('working_days') * setting('working_hours')) , 2)  ;

        $this->perHour =    $perHour ;

        foreach ($productionOrder->items as $item){
            $this->cost +=  $item->pivot->amount * $item->price;
        }
        $this->expected_amount = $this->productionOrder->amount - ($this->productionOrder->amount *.05);
        $this->expected_price =  (float)  $this->cost /   $this->expected_amount;
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
        if($this->working_hours){
        $salaries =  array_sum(\App\Models\Employee::pluck('salary')->toArray());
          $perHour = (float)  number_format($salaries /  (setting('working_days') * setting('working_hours')) , 2)  ;
            $this->hourCost = $this->working_hours * $perHour;
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
            $this->cost_per_unit = $this->totalCost / $this->quantity ;
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

    public function save()
    {
        $validated = $this->validate();

        $this->cal();

        Item::create([
           'name' => $this->productionOrder->formula->product->name,
            'quantity' =>    $validated['quantity'],
            'description' => $validated['description'], null,
            'cost' => $this->cost_per_unit,
            'price' =>   $validated['price'],
            'user_id' => auth()->id() ,
            'production_order_id' =>  $this->productionOrder->id ,
            'type' => 'product',

        ]);
        $this->productionOrder->done_at = now();
        $this->productionOrder->save();
    }
}
