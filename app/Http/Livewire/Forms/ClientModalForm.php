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
        'status_id' => 'required|numeric',
        'company_id' => 'nullable|numeric'
//        'email' => 'required',
//        'address' => 'required',
    ];

    public $name ;
    public $phone ;
    public $status_id;
    public $company_id;
//    public $email ;
//    public $address;
    public $client;

    public $updateMode = false;

    public function render()
    {
        return view('livewire.forms.client-modal-form',[
            'companies' => Company::where('active',true)->get(),
            'statuses' => Status::where('type','client')->get()
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
        $this->client =   Client::create($validated);
        $this->emitTo('forms.invoice-form','selectClient',$this->client->id);
        $this->dispatchBrowserEvent('closeModel');
    }
}
