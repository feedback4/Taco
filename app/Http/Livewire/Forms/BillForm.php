<?php

namespace App\Http\Livewire\Forms;

use App\Models\Bill;
use App\Models\Element;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Status;
use App\Models\Tax;
use App\Models\Vendor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class BillForm extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['selectVendor', 'selectItem', 'createItem'];

    public $bill;

    public $vendor;
    public $searchVendors = [];
    public $query = '';
    public $partial = false;

    public $billed_at ;
    public $due_at;
    public $number , $code;
    public $status_id;
    public $partial_amount = 0;
    public $notes;

    public $items = [];
    public $billItems = [];
    public $amount = [];
    public $tax_id;


    public $subTotal = 0;
    public $discount = 0;
    public $taxTotal = 0;
    public $total = 0;

    public $button = 'create';
    public $color = 'success';

    public function mount($bill = null)
    {
        if ($bill) {
            $this->bill = $bill;

            $this->billed_at = $this->bill->billed_at->format('Y-m-d');
            $this->due_at = $this->bill->due_at->format('Y-m-d');
            $this->code = $this->bill->code;
            $this->status_id = $this->bill->status_id;
            $this->vendor = Vendor::find($this->bill->vendor_id);
            $this->notes = $this->bill->notes;
            $this->tax_id = $this->bill->tax_id;

            $this->partial_amount = $this->bill->payments()->sum('amount');

            foreach ($bill->items as $k => $item) {
                $this->billItems[$k] = ['name' => $item->name,'element_id' => $item->element_id, 'description' => $item->description, 'quantity' => $item->quantity, 'price' => $item->price];
            }
            $this->discount = $this->bill->discount;

            $statusId = Status::where('type', 'bill')->where('name', 'partial')->first()->id;

            if ($this->status_id == $statusId) {
                $this->partial = true;
            } else {
                $this->partial = false;
            }

            $this->button = 'update';
            $this->color = 'primary';
            $this->cal();
        }else{
              //  $year =   now()->format('y');

            $latest = Bill::latest()->first()->id ?? 0;
            $this->code = 'bill-' . (str_pad((int)$latest + 1, 5, '0', STR_PAD_LEFT));
            $this->billed_at =  now()->format('Y-m-d');
            $this->due_at =  now()->addDays(14)->format('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.forms.bill-form', [
            'statuses' => Status::where('type', 'bill')->get(),
            'taxes' => Tax::where('active', true)->get(),

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
        $this->billItems[] = ['name' => $element->name .' -- '.$element->code ,'element_id' => $element->id, 'description' => '', 'quantity' => 1, 'price' => 0];
    }

    public function createItem()
    {
        $this->billItems[] = ['name' => '', 'element_id' => 0 ,'description' => '', 'quantity' => 1, 'price' => 0];
    }

    public function deleteItem($index)
    {
        unset($this->billItems[$index]);
        unset($this->amount[$index]);
        $this->cal();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedStatusId()
    {
        if ($this->status_id) {
            $statusId = Status::where('name', 'partial')->where('type', 'bill')->first()->id;
           // dd($statusId);
            if ($this->status_id == $statusId) {
                $this->partial = true;
            } else {
                $this->partial = false;
            }
        }
    }

    public function updatedBillItems()
    {
        $this->cal();
    }

    public function updatedTaxId()
    {
        if ($this->tax_id){
            $this->cal();
        }else{
            $this->tax_id = 0;
            $this->taxTotal = 0 ;
            $this->cal();
        }
    }

    public function updatedDiscount()
    {
        if ($this->discount){
            $this->cal();
        }else{
            $this->discount = 0;
            $this->cal();
        }

    }

    private function cal()
    {
        $this->subTotal = 0;
        $this->total = 0;
        foreach ($this->billItems as $k => $itm) {
            $this->amount[$k] = ( (float) $this->billItems[$k]['quantity'] ?? 0 ) * ( (float) $this->billItems[$k]['price'] ?? 0 );
        }
//dd( $this->amount);
        foreach ($this->amount as $m) {
            $this->subTotal += $m;
        }

        if ($this->tax_id) {
            $percent = Tax::find($this->tax_id)->percent;
            $this->taxTotal = $this->subTotal *  ($percent /100)  ;
            $this->total = $this->subTotal + $this->taxTotal - $this->discount ;
        } else {
            $this->total = $this->subTotal - $this->discount;
        }
    }

    public function save()
    {
     //   dd($this->billItems);
        $this->authorize('purchases');

        if (!$this->vendor) {
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Please Select or Create a Vendor']);
            return;
        }
        if(empty($this->billItems)) {
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Please Select at least 1 item']);
            return;
        }

        if ($this->partial){
            if ($this->partial_amount == 0 ){
                $this->emit('alert',
                    ['type' => 'error', 'message' => 'The partial amount must be greater than 0']);
                return;
            }
        }

            $validated = $this->validate();


        $this->cal();


        if ($this->partial_amount >= $this->total) {
            $this->emit('alert',
                ['type' => 'error', 'message' => 'partial paid amount can\'t be more than total ']);
            return;
        }

        $data = [
            'billed_at' => $validated['billed_at'],
            'due_at' => $validated['due_at'],
            'status_id' => $validated['status_id'],
            'code' => $this->code ?? null,
            'number' => $validated['number'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'vendor_id' => $this->vendor->id,
            'tax_id' => $this->tax_id,
            'partial_amount' => $this->partial_amount ,
            'sub_total' => $this->subTotal,
            'discount' => $this->discount,
            'tax_total' => $this->taxTotal,
            'total' => $this->total,
        ];

        if ($this->bill) {
            $this->bill->update($data);
            foreach ($this->bill->items as $item) {
                $item->delete();
            }

            foreach ($validated['billItems'] as $itm) {

                Item::create([
                    'name' => $itm['name'],
                    'description' => $itm['description'] ?? null,
                    'quantity' => floatval($itm['quantity']),
                    'price' => floatval($itm['price'] ) ,
                    'bill_id' => $this->bill->id,
                    'user_id' => auth()->id(),
                    'element_id' => $itm['element_id']
                ]);
            }
            $this->emit('alert',
                ['type' => 'info', 'message' => 'Bill Updated Successfully!']);
            $bill =   $this->bill ;
        } else {
            $bill = Bill::create($data);

            foreach ($validated['billItems'] as $k => $itm) {

                Item::create([
                    'name' => $itm['name'],
                    'description' => $itm['description'] ?? null,
                    'quantity' => floatval($itm['quantity']),
                    'price' => floatval($itm['price']),
                    'bill_id' => $bill->id,
                    'user_id' => auth()->id(),
                    'element_id' =>  $itm['element_id']
                ]);
            }




            $this->emit('alert',
                ['type' => 'success', 'message' => 'Bill Created Successfully!']);
        }

        if ($bill->status->name != 'unpaid'){
            $amount= 0;
            if ($bill->status->name == 'paid'){
                $amount = $bill->total ;
            }elseif($bill->status->name == 'partial'){
                $amount = $this->partial_amount;
            }
            Payment::create([
                'paid_at' => $bill->billed_at,
                'amount' => $amount,
                'bill_id' => $bill->id,
                'vendor_id' => $this->vendor->id,
            ]);
        }

        //    $this->emitTo('tables.formulas-table','refreshFormulas');
        $this->reset();

        if ($this->authorize('inventory')){
            return redirect()->route('inventory.pending');
        }

        return redirect()->route('purchases.bills.index');
    }

    protected function rules()
    {
        return [
            'number' => ['nullable', Rule::unique('bills')->ignore($this->bill?->id)],

            'billed_at' => 'required|date',
            'due_at' => 'required|date',
            'status_id' => 'required|numeric|exists:statuses,id',
            'notes' => 'nullable',

            'partial_amount' => 'nullable|numeric', // sometimes|gt:0

            'discount' => 'nullable|numeric',

            'billItems.*.name' => 'required',
            'billItems.*.element_id' => 'nullable|numeric',
            'billItems.*.description' => 'nullable',

            'billItems.*.quantity' => 'required|numeric|min:0|max:10000',
            'billItems.*.price' => 'required|numeric|min:0',
        ];
    }


}
