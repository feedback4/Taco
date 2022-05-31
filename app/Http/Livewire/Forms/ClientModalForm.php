<?php

namespace App\Http\Livewire\Forms;

use App\Models\Client;
use App\Models\Company;
use App\Models\Status;
use Livewire\Component;

class ClientModalForm extends Component
{
    protected $rules = [
        'name' => 'required',
        'phone' => 'required',
        'type' => 'required',
        'payment' => 'required',
        'location' => 'required',
        'status_id' => 'required|numeric',
        'company_id' => 'nullable|numeric',
        'vat' => 'required|boolean',
//        'email' => 'required',
//        'address' => 'required',
    ];

    public $name ;
    public $phone ;
    public $status_id;
    public $type ;
    public $payment ;
    public $vat = true;
    public $location ;
    public $company_id;
//    public $email ;
//    public $address;
    public $client;

    public $updateMode = false;

    public function render()
    {
        return view('livewire.forms.client-modal-form',[
            'companies' => Company::where('active',true)->get(),
            'statuses' => Status::where('type','client')->get(),
              'types' =>  Client::$types,
            'payments' =>  Client::$payments,
        ]);
    }

    public  function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function open()
    {
        $this->updateMode = true;
    }
    public function close()
    {
        $this->updateMode = false;
        $this->dispatchBrowserEvent('closeModel');
    }

    public function save()
    {
        $validated =  $this->validate();
    //    dd($validated);
        $this->client =   Client::create($validated);
        $this->emitTo('forms.invoice-form','selectClient',$this->client->id);
        $this->dispatchBrowserEvent('closeModel');
    }
}
