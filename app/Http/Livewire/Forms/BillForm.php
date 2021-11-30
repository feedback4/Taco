<?php

namespace App\Http\Livewire\Forms;

use App\Models\Bill;
use App\Models\Element;
use App\Models\Item;
use App\Models\Status;
use App\Models\Tax;
use App\Models\Vendor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class BillForm extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['selectVendor','selectItem','createItem' ];

    public $bill ;

    public $vendor ;
    public $searchVendors= [];
    public $query = '';

    public $billed_at ;
    public $due_at ;
    public $bill_number ;
    public $status_id ;
    public $notes ;

    public $items = [] ;
    public $billItems = [];
    public $amount= [];
    public $tax_id ;

    public $subTotal = 0 ;
    public $discount = 0 ;
    public $total = 0 ;

    public $button = 'create';
    public $color = 'success';

    public function mount($bill = null)
    {
        if ($bill){
            $this->bill = $bill;


            $this->billed_at = $this->bill->billed_at->format('Y-m-d');
            $this->due_at = $this->bill->due_at->format('Y-m-d');
            $this->bill_number = $this->bill->bill_number;
            $this->status_id = $this->bill->status_id;
            $this->vendor =  Vendor::find($this->bill->vendor_id);
            $this->notes = $this->bill->notes;
            $this->tax_id = $this->bill->tax_id;

            foreach ($this->bill->items as $k => $item) {
                $this->billItems[$k] = ['name' => $item->name,'description' =>$item->description , 'quantity' => $item->quantity , 'price'=>$item->price ];
            }
            $this->discount = $this->bill->discount;

            $this->button = 'update';
            $this->color = 'primary';
            $this->cal();
        }
    }
    public function render()
    {
        return view('livewire.forms.bill-form',[
            'statuses' => Status::where('type','bill')->get(),
            'taxes' => Tax::where('active',true)->get(),

        ]);
    }

    public function updatedQuery()
    {
        $this->searchVendors = Vendor::search($this->query)->take(5)->get();
    }
    public function selectVendor($id)
    {
        $this->vendor = Vendor::find($id);
    }
    public function clearVendor()
    {
        $this->reset('vendor');
    }

    public function selectItem($id)
    {
        $element = Element::find($id);
        $this->billItems[] = ['name'=>$element->code ,'description'=>'','quantity'=>1,'price'=>0];
    }
    public function createItem()
    {
        $this->billItems[] = ['name'=>'','description'=>'','quantity'=>1,'price'=>0];
    }
    public function deleteItem($index)
    {
       unset($this->billItems[$index])   ;
       unset($this->amount[$index]);
        $this->cal();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedBillItems()
    {
        $this->cal();
    }
    public function updatedTaxId()
    {
        $this->cal();
    }
    public function updatedDiscount()
    {
        $this->cal();
    }
    public function cal()
    {
        $this->subTotal = 0;
        $this->total = 0;
        foreach ($this->billItems as $k => $itm){
            $this->amount[$k] = $this->billItems[$k]['quantity'] * $this->billItems[$k]['price'];
        }


        foreach ($this->amount as $m){
            $this->subTotal += $m ;
        }

        if ($this->tax_id){
             $percent = Tax::find($this->tax_id)->percent;
            $this->total =    $this->subTotal - $this->discount  + (  $this->subTotal * $percent /100)  ;
        }else{
            $this->total =    $this->subTotal - $this->discount ;
        }
    }

    public function save()
    {
        $this->authorize('purchases');

        if (!$this->vendor){
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Please Select or Create a Vendor']);
            return ;
        }

        $validated = $this->validate();
        $this->cal();

        $data = [
            'billed_at' => $validated['billed_at'],
            'due_at' => $validated['due_at'],
            'status_id' => $validated['status_id'],
            'bill_number' => $validated['bill_number'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'vendor_id' => $this->vendor->id,
            'tax_id' => $this->tax_id ,
            'discount' => $this->discount,
            'sub_total' => $this->subTotal,
            'total' => $this->total,
        ];

        if ($this->bill) {
            $this->bill->update($data);
            foreach ($this->bill->items as $item){
                $item->delete();
            }

            foreach ($validated['billItems'] as $itm) {
                $elementId =  Element::where('code',$itm['name'])->first()?->id;
                Item::create([
                    'name' => $itm['name'],
                    'description' => $itm['description'] ?? null,
                    'quantity' => intval($itm['quantity']),
                    'price' => floatval($itm['price']),
                    'bill_id' => $this->bill->id,
                    'user_id' => auth()->id(),
                    'element_id' => $elementId
                ]);
            }
            $this->emit('alert',
                ['type' => 'info', 'message' => 'Formula Updated Successfully!']);
        } else {
            $bill = Bill::create($data);

            foreach ($validated['billItems'] as $k => $itm) {
               $elementId =  Element::where('code',$itm['name'])->first()?->id;
                Item::create([
                    'name' => $itm['name'],
                    'description' => $itm['description'] ?? null,
                    'quantity' => intval($itm['quantity']),
                    'price' => floatval($itm['price']),
                    'bill_id' => $bill->id,
                    'user_id' => auth()->id(),
                    'element_id' => $elementId
                ]);
            }

            $this->emit('alert',
                ['type' => 'success', 'message' => 'Bill Created Successfully!']);
        }
        //    $this->emitTo('tables.formulas-table','refreshFormulas');
        $this->reset();

        return redirect()->route('purchases.bills.index');
    }

    protected function rules()
    {
        return [
            'bill_number' => ['nullable', Rule::unique('bills')->ignore($this->bill?->id)],

            'billed_at' => 'required|date',
            'due_at' => 'required|date',
            'status_id' => 'required|numeric',
            'notes' => 'nullable',

            'discount' => 'nullable|numeric',

            'billItems.*.name' => 'required',
            'billItems.*.description' => 'nullable',
            'billItems.*.quantity' => 'required|numeric|min:0|max:10000',
            'billItems.*.price' => 'required|numeric|min:0',
        ];
    }






}