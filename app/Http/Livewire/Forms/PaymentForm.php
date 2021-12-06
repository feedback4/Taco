<?php

namespace App\Http\Livewire\Forms;

use App\Models\Bill;
use App\Models\Payment;
use App\Models\Status;
use App\Models\Vendor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PaymentForm extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['selectVendor'];

    public $payment;

    public $paid_at;
    public $amount = 0;
    public $bill_id;
    public int $sub = 0 ;

    public $vendor;
    public $bills ;
    public $searchVendors = [];
    public $query = '';

    public $button = 'create';
    public $color = 'success';
    public $edit = false;

    public function mount($payment = null)
    {
        $this->paid_at =  now()->format('Y-m-d');

        if ($payment) {
            $this->payment = $payment;

        //    $this->paid_at = $this->payment->paid_at->format('Y-m-d');
            $this->amount = $this->payment->amount;
        $this->selectVendor($this->payment->vendor_id) ;


            $this->button = 'update';
            $this->color = 'primary';
            $this->edit = true ;

        }
    }

    public function render()
    {
        return view('livewire.forms.payment-form');
    }
    public function updatedQuery()
    {
        $this->searchVendors = Vendor::search($this->query)->take(5)->get();
    }

    public function selectVendor($id)
    {
        $this->vendor = Vendor::find($id);
        $this->bills =$this->vendor->bills()->whereHas('status', fn($q)=>$q->whereNotIn('name',['paid']))->get();
    }

    public function clearVendor()
    {
        $this->reset('vendor');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedBillId()
    {
        if ($this->bill_id){
            $bill = Bill::findOrFail($this->bill_id);
            $this->sub =  $bill->total - $bill->payments()->sum('amount');
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
        if ($this->bill_id && $this->amount) {
            if ($this->sub < $this->amount ){
                $this->emit('alert',
                    ['type' => 'warning', 'message' => 'payment amount is more than bill unpaid amount']);
                return false ;
            }elseif($this->sub == $this->amount){
                $this->emit('alert',
                    ['type' => 'info', 'message' => 'the bill will be fully paid']);
                return true ;
            }
        }

        return true ;
    }

    public function sum()
    {
   if ($this->payment){
       $this->bill_id = $this->payment->bill_id ;
       $bill = Bill::findOrFail($this->bill_id);
       $total =  $bill->payments()->sum('amount');

       $this->sub =  $bill->total - $total;
       if ($this->sub == 0){
           $status_id = Status::where('type','bill')->where('name','paid')->first()->id;
           $bill->status_id =$status_id ;
           $bill->save();
       }elseif($total == 0){
           $status_id = Status::where('type','bill')->where('name','unpaid')->first()->id;
           $bill->status_id =$status_id ;
           $bill->payments()->delete();
           $bill->save();
       }
   }

    }

    public function clear()
    {
        if ($this->payment){
            $this->payment->amount = 0;
            //  $this->revenue->paid_at = null ;
            $this->payment->save();
            $this->emitSelf('$refresh');
            $this->sum();
            $this->cal();
        }
    }
    public function save()
    {
        $this->authorize('purchases');

        if (!$this->vendor) {
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Please Select or Create a Vendor']);
            return ;
        }

        $validated = $this->validate();
       if (!$this->cal()) {
           $this->emit('alert',
               ['type' => 'error', 'message' => 'wrong']);
           return ;
        }

       $validated['vendor_id'] = $this->vendor->id ;
        $validated['bill_id'] = $this->bill_id ;

        if ($this->payment) {
            $this->payment->update($validated);

            $this->emit('alert',
                ['type' => 'info', 'message' => 'Payment Updated Successfully!']);
        } else {
           Payment::create($validated);



            $this->emit('alert',
                ['type' => 'success', 'message' => 'Payment Added Successfully!']);
        }

        //    $this->emitTo('tables.formulas-table','refreshFormulas');
        $this->reset();

        return redirect()->route('purchases.payments.index');
    }

    protected function rules()
    {
        return [
            'paid_at' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'bill_id' => 'nullable|numeric|min:0'
        ];
    }
}
