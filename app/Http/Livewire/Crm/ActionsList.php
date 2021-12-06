<?php

namespace App\Http\Livewire\Crm;

use App\Models\Action;
use App\Models\Compound;
use Livewire\Component;
use Livewire\WithPagination;

class ActionsList extends Component
{
    use WithPagination;
    protected $listeners = ['refreshActions' => '$refresh'];
    protected $paginationTheme = 'bootstrap';

    public $update;

    public function refreshComponent() {
        sleep(2);
        $this->update = !$this->update;
        dd($this->update);
        //$this->emitSelf('$refresh');
    }
    public function render()
    {
        return view('livewire.crm.actions-list',[
            'actions' => Action::with(['client'=>fn($q)=>$q->select('id','name'),'employee'])->orderByDesc('due_at')->paginate(10)
        ]);
    }
    public function done(int $actionId)
    {
        $action =Action::findOrFail($actionId);
        if ($action->done_at){
            $action->done_at = null;
            $action->save();
        }else{
            $action->done_at = now();
            $action->save();
        }
    }

    public function edit(int $actionId)
    {
        $action = Action::find($actionId);

        if ($action->done_at){
            $this->emit('alert',
                ['type' => 'warning',  'message' => 'Action is already done !']);
            return ;
        }else{
            $this->emitTo('crm.action-create','editAction',$actionId);
        }

    }

    public function delete(int $actionId)
    {
        $action =Action::findOrFail($actionId);
//        if (isset($compound->elements[0]) ){
//            $this->emit('alert',
//                ['type' => 'warning',  'message' => 'Compound Still Have Elements']);
//            return back();
//        }
        $action->delete();
        $this->emitSelf('refreshActions');
        $this->emit('alert',
            ['type' => 'success',  'message' => 'Action Deleted Successfully!']);
    }
}
