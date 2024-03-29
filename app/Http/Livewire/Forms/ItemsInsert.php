<?php

namespace App\Http\Livewire\Forms;

use App\Models\Element;

use App\Models\Item;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class ItemsInsert extends Component
{
    public $insertItems = ['',''] ;

    protected $rules = [
//        "element_id"    => "required|array",
//        "amount"    => "required|array",
//        "unit"    => "required|array",
//        "expire_at"    => "required|array",

        "element_id.*"  => "required|numeric",
        "amount.*"  => "required|numeric|min:0",
        "unit.*"  => "required",
        "expire_at.*"  => "required|date",// |after:today
    ];
    public array $amount=[]  ;
    public array $unit=[] ;
    public array $expire_at=[] ;
    public array $element_id=[] ;
    public int $inventoryId ;

    public $elements ;
    public function mount($inventoryId)
    {
        $this->inventoryId = $inventoryId;
        $this->elements = Element::select('id','name','code')->get();
    }

    public function render()
    {
        return view('livewire.forms.items-insert',[
        'units' => Item::$units
        ]);
    }
    public function addItem()
    {
        $this->insertItems[] = '2';
    }
    public  function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function save()
    {
        $validated =  $this->validate();
        foreach ($this->amount as $k=> $i){
            Item::create([
                'element_id' => $this->element_id[$k],
                'amount' => $this->amount[$k],
                'unit' => $this->unit[$k],
                'expire_at' => $this->expire_at[$k],
                'inventory_id' =>   $this->inventoryId  ,
                'user_id' => auth()->id(),
            ]);
        }
        $this->emit('alert',
            ['type' => 'info',  'message' => 'Items Created Successfully!']);
        return redirect()->route('inventories.show',  $this->inventoryId );
    }
}
