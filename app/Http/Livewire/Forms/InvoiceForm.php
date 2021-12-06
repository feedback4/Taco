<?php

namespace App\Http\Livewire\Forms;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Revenue;
use App\Models\Status;
use App\Models\Tax;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class InvoiceForm extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['selectClient', 'selectItem', 'createItem'];

    public $invoice;

    public $client;
    public $searchClients = [];
    public $query = '';
    public $partial = false;

    public $invoiced_at ;
    public $due_at;
    public $number;
    public $status_id;
    public $partial_amount = 0;
    public $notes;

    public $items = [];
    public $invoiceItems = [];
    public $amount = [];
    public $tax_id;

    public $subTotal = 0;
    public $discount = 0;
    public $total = 0;

    public $button = 'create';
    public $color = 'success';

    public function mount($invoice = null)
    {
        $this->invoiced_at =  now()->format('Y-m-d');
        $this->due_at =  now()->format('Y-m-d');
        if ($invoice) {
            $this->invoice = $invoice;


            $this->invoiced_at = $this->invoice->invoiced_at->format('Y-m-d');
            $this->due_at = $this->invoice->due_at->format('Y-m-d');
            $this->number = $this->invoice->number;
            $this->status_id = $this->invoice->status_id;
            $this->client = Client::find($this->invoice->client_id);
            $this->notes = $this->invoice->notes;
            $this->tax_id = $this->invoice->tax_id;


            foreach ($this->invoice->items as $k => $item) {
                if ($this->tax_id){
                    $percent = Tax::find($this->tax_id)->percent ?? 0;
                    $item->price = floatval($item->price /(100+$percent)* 100 ) ;
                 }
                    $this->invoiceItems[$k] = ['name' => $item->name, 'description' => $item->description, 'quantity' => $item->quantity, 'price' => $item->price];
                }
            $this->discount = $this->invoice->discount;


            $this->button = 'update';
            $this->color = 'primary';
            $this->cal();
            $statusId = Status::where('name', 'partial')->where('type', 'bill')->first()->id;

            if ($this->status_id == $statusId) {
                $this->partial = true;
            } else {
                $this->partial = false;
            }
        }
    }

    public function render()
    {
        return view('livewire.forms.invoice-form', [
            'statuses' => Status::where('type', 'bill')->get(),
            'taxes' => Tax::where('active', true)->get(),
        ]);
    }

    public function updatedQuery()
    {
        $this->searchClients = Client::search($this->query)->take(5)->get();
    }

    public function selectClient($id)
    {
        $this->client = Client::with('company')->find($id);
    }

    public function clearClient()
    {
        $this->reset('client');
    }

    public function selectItem($id)
    {
        $product = Product::find($id);
        $item  = Item::where('product_id',$product->id)->first();
        $this->invoiceItems[] = ['name' => $product->code, 'description' => '', 'quantity' => 1, 'price' => $item?->price];
    }

    public function createItem()
    {
        $this->invoiceItems[] = ['name' => '', 'description' => '', 'quantity' => 1, 'price' => 0];
    }

    public function deleteItem($index)
    {
        unset($this->invoiceItems[$index]);
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

    public function updatedInvoiceItems()
    {
        $this->cal();
    }

    public function updatedTaxId()
    {
        if ($this->tax_id){
            $this->cal();
        }else{
            $this->tax_id = 0;
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
        foreach ($this->invoiceItems as $k => $itm) {
            $this->amount[$k] = $this->invoiceItems[$k]['quantity'] * $this->invoiceItems[$k]['price'];
        }


        foreach ($this->amount as $m) {
            $this->subTotal += $m;
        }

        if ($this->tax_id) {
            $percent = Tax::find($this->tax_id)->percent;
            $this->total = ($this->subTotal / 100 * (100+$percent) )- $this->discount ;
        } else {
            $this->total = $this->subTotal - $this->discount;
        }
    }

    public function save()
    {
        $this->authorize('sales');

        if (!$this->client) {
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Please Select or Create a Client']);
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

        if(empty($this->invoiceItems)) {
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Please Select at least 1 item']);
            return;
        }

        if ($this->partial_amount >= $this->total) {
            $this->emit('alert',
                ['type' => 'error', 'message' => 'partial paid amount can\'t be more than total ']);
            return;
        }

        $data = [
            'invoiced_at' => $validated['invoiced_at'],
            'due_at' => $validated['due_at'],
            'status_id' => $validated['status_id'],
            'number' => $validated['number'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'client_id' => $this->client->id,
            'tax_id' => $this->tax_id,
            'partial_amount' => $this->partial_amount ,
            'discount' => $this->discount,
            'sub_total' => $this->subTotal,
            'total' => $this->total,
        ];

        if ($this->invoice) {
            $this->invoice->update($data);
            foreach ($this->invoice->items as $item) {
                $item->delete();
            }

            foreach ($validated['invoiceItems'] as $itm) {
                $productId = Product::where('code', $itm['name'])->first()?->id;
                $percent = 0;
                if ($this->tax_id){
                    $percent = Tax::find($this->tax_id)->percent ?? 0;
                }
                Item::create([
                    'name' => $itm['name'],
                    'description' => $itm['description'] ?? null,
                    'quantity' => intval($itm['quantity']),
                    'price' => floatval($itm['price']  / 100 * (100+$percent)) ,
                    'invoice_id' => $this->invoice->id,
                    'user_id' => auth()->id(),
                    'product_id' => $productId
                ]);
            }
            $this->emit('alert',
                ['type' => 'info', 'message' => 'Invoice Updated Successfully!']);
            $invoice =   $this->invoice ;
        } else {
            $invoice= Invoice::create($data);

            foreach ($validated['invoiceItems'] as $k => $itm) {
                $productId = Product::where('code', $itm['name'])->first()?->id;
                Item::create([
                    'name' => $itm['name'],
                    'description' => $itm['description'] ?? null,
                    'quantity' => intval($itm['quantity']),
                    'price' => floatval($itm['price']),
                    'invoice_id' => $invoice->id,
                    'user_id' => auth()->id(),
                    'product_id' => $productId
                ]);
            }

            $this->emit('alert',
                ['type' => 'success', 'message' => 'Invoice Created Successfully!']);
        }

        if ($invoice->status->name != 'unpaid'){
            $amount= 0;
            if ($invoice->status->name == 'paid'){
                $amount = $invoice->total ;
            }elseif($invoice->status->name == 'partial'){
                $amount = $this->partial_amount;
            }
            Revenue::create([
                'paid_at' => $invoice->invoiced_at,
                'amount' => $amount,
                'invoice_id' => $invoice->id,
                'client_id' => $this->client->id,
            ]);
        }

        //    $this->emitTo('tables.formulas-table','refreshFormulas');
        $this->reset();

        return redirect()->route('sales.invoices.index');
    }

    protected function rules()
    {
        return [
            'number' => ['nullable', Rule::unique('invoices')->ignore($this->invoice?->id)],

            'invoiced_at' => 'required|date',
            'due_at' => 'required|date',
            'status_id' => 'required|numeric',
            'notes' => 'nullable',

            'partial_amount' => '|nullable|numeric',//sometimes|gt:0

            'discount' => 'nullable|numeric',

            'invoiceItems.*.name' => 'required',
            'invoiceItems.*.description' => 'nullable',
            'invoiceItems.*.quantity' => 'required|numeric|min:0|max:10000',
            'invoiceItems.*.price' => 'required|numeric|min:0',
        ];
    }


}
