<?php

namespace App\Http\Livewire\Tables;

use App\Models\Formula;
use Livewire\Component;
use Livewire\WithPagination;

class FormulasTable extends Component
{
    use WithPagination;
    protected $listeners = ['refreshFormulas' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;

    public function render()
    {
        return view('livewire.tables.formulas-table',[
            'formulas' => Formula::search($this->search)
                ->with('category')
                //    ->whereHas("roles", function($q){ $q->whereNotIn("name", ["seller"]); })
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
    public function edit(int $formulaId)
    {
        $this->emitTo('forms.formula-form','editFormula',$formulaId);
    }
    public function delete(int $formulaId)
    {
        $formula = Formula::findOrFail($formulaId);
        if (isset($category->children[0]) ){
            $this->emit('alert',
                ['type' => 'warning',  'message' => 'Formula Still Have Children']);
            return back();
        }
        $formula->delete();
        $this->emitSelf('refreshFormulas');
        $this->emit('alert',
            ['type' => 'success',  'message' => 'Formula Deleted Successfully!']);
    }
}
