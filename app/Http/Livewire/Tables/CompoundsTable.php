<?php

namespace App\Http\Livewire\Tables;

use App\Models\Compound;
use Livewire\Component;
use Livewire\WithPagination;

class CompoundsTable extends Component
{
    use WithPagination;
    protected $listeners = ['refreshCompounds' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderDesc = true;

    public function render()
    {
        return view('livewire.tables.compounds-table',
        [
            'compounds' => Compound::with('elements')->get()
        ]);

    }
    public function edit(int $compoundId)
    {
        $this->emitTo('forms.compounds-form','editCompound',$compoundId);
    }
    public function delete(int $compoundId)
    {
        $compound =Compound::findOrFail($compoundId);
//        if (isset($compound->elements[0]) ){
//            $this->emit('alert',
//                ['type' => 'warning',  'message' => 'Compound Still Have Elements']);
//            return back();
//        }
        $compound->delete();
        $this->emitSelf('refreshCompounds');
        $this->emit('alert',
            ['type' => 'success',  'message' => 'Compound Deleted Successfully!']);
    }
}
