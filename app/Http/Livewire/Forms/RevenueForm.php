<?php

namespace App\Http\Livewire\Forms;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Revenue;
use App\Models\Status;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class RevenueForm extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['selectClient'];

    public $revenue;

    public $paid_at;
    public $amount = 0;
    public $invoice_id;
    public int $sub = 0 ;

    public $client;
    public $invoices ;
    public $searchClients = [];
    public $query = '';

    public $button = 'create';
    public $color = 'success';
    public $edit = false;

    public function mount($revenue = null)
    {
        $this->paid_at =  now()->format('Y-m-d');

        if ($revenue) {
            $this->revenue = $revenue;

            //    $this->paid_at = $this->payment->paid_at->format('Y-m-d');
            $this->amount = $this->revenue->amount;

            $this->selectClient($this->revenue->client_id) ;
            $this->invoice_id = $this->revenue->invoice_id;


            $this->button = 'update';
            $this->color = 'primary';
            $this->edit = true ;
            $this->cal();
        }
    }

    public function render()
    {
        return view('livewire.forms.revenue-form');
    }
    public function updatedQuery()
    {
        $this->searchClients = Client::search($this->query)->take(5)->get();
    }

    public function selectClient($id)
    {
        $this->client = Client::find($id);

            $this->invoices =$this->client->invoices()->whereHas('status', fn($q)=>$q->whereNotIn('name',['paid']))->get();

            if ($this->revenue){
                if( !$this->invoices->contains('id',$this->revenue->invoice_id))
                {
                    $invoice = Invoice::find($this->revenue->invoice_id);
                    $this->invoices->push($invoice);
                }
            }
    }

    public function clearClient()
    {
        $this->reset('client');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedInvoiceId()
    {
        if ($this->invoice_id){

            $this->cal();
        }else{
            $this->sub = 0;
        }
    }
    public function updatedAmount()
    {
        $this->cal();
    }
    public function cal()
    {
        if ($this->invoice_id ) {
            $invoice = Invoice::findOrFail($this->invoice_id);
            $this->sub =  $invoice->total - $invoice->revenues()->sum('amount');
            if ($this->sub < $this->amount ){
                $this->emit('alert',
                    ['type' => 'warning', 'message' => 'Revenue amount is more than invoice unpaid amount']);
                return false ;
            }elseif($this->sub == $this->amount){
                $this->emit('alert',
                    ['type' => 'info', 'message' => 'the Invoice will be fully paid']);
                return true ;
            }
        }

        return true ;
    }
    public function clear()
    {
        if ($this->revenue){
            $this->revenue->amount = 0;
          //  $this->revenue->paid_at = null ;
            $this->revenue->save();
            $this->emitSelf('$refresh');
            $this->cal();
        }
    }
    public function save()
    {
        $this->authorize('sales');

        if (!$this->client) {
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Please Select or Create a Client']);
            return ;
        }

        $validated = $this->validate();
        if (!$this->cal()) {
            $this->emit('alert',
                ['type' => 'error', 'message' => 'wrong']);
            return ;
        }

        $validated['client_id'] = $this->client->id ;
      //  $validated['paid_at'] = now();

        if ($this->revenue) {
            $this->revenue->update($validated);

            $this->emit('alert',
                ['type' => 'info', 'message' => 'Revenue Updated Successfully!']);
        } else {
            Revenue::create($validated);



            $this->emit('alert',
                ['type' => 'success', 'message' => 'Revenue Added Successfully!']);
        }
        $invoice = Invoice::findOrFail($this->invoice_id);
         $total =  $invoice->revenues()->sum('amount');

        $this->sub =  $invoice->total - $total;


        if ($this->sub == 0){
            $status_id = Status::where('type','bill')->where('name','paid')->first()->id;
            $invoice->status_id =$status_id ;
            $invoice->save();
        }elseif($total == 0){
            $status_id = Status::where('type','bill')->where('name','unpaid')->first()->id;
            $invoice->status_id =$status_id ;
            $invoice->revenues()->delete();
            $invoice->save();
        }

        //    $this->emitTo('tables.formulas-table','refreshFormulas');
        $this->reset();

        return redirect()->route('sales.revenues.index');
    }

    protected function rules()
    {
        return [
            'paid_at' => 'required|date',
            'amount' => 'required|numeric|gt:0',
            'invoice_id' => 'nullable|numeric|exists:invoices,id'
        ];
    }
}
