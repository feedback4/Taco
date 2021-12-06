<?php

namespace App\Http\Livewire\Crm;

use App\Models\Action;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class ActionCreate extends Component
{
    use AuthorizesRequests;
    protected $listeners = ['editAction' => 'edit' ];
    protected $rules = [
        'type' => 'required',
        'due_at' => 'required|date',
        'description' => 'nullable',
        'employee_id' => 'required|numeric|exists:employees,id',
        'client_id' => 'required|numeric|exists:clients,id',
    ];

    public $type ;
    public $due_at ;
    public $description ;
    public $employee_id ;
    public $client_id ;


    public $title = 'create' ;
    public $button = 'create' ;
    public $color = 'success';
    public $action;



    public function render()
    {
        return view('livewire.crm.action-create',
        [
            'types' => Action::$types,
            'employees' => Employee::where('active',true)->select('id','name')->get(),
            'clients' => Client::select('id','name')->get()
        ]);

    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function edit(int $actionId)
    {
        $this->action = Action::findOrFail( $actionId);

        $this->type = $this->action->type;
        $this->due_at = $this->action->due_at;
        $this->description = $this->action->description;
        $this->employee_id = $this->action->employee_id;
        $this->client_id = $this->action->client_id;

        $this->title = 'Edit';
        $this->button = 'Update';
        $this->color = 'primary';
    }

    public function save()
    {
        $this->authorize('crm');
        $validated = $this->validate();
        $validated['user_id'] = auth()->id();
        if(!$this->action){
            Action::create($validated);
            $this->emit('alert',
                ['type' => 'success', 'message' => 'Action Created Successfully!']);
        }else{
            $this->action->update($validated);
            $this->emit('alert',
                ['type' => 'success', 'message' => 'Action Updated Successfully!']);
        }

        $this->emitTo('crm.actions-list','refreshActions');
        $this->reset();
    }

}
