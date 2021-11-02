<?php

namespace App\Http\Livewire\Tables;

use App\Models\Element;
use Livewire\Component;
use Livewire\WithPagination;

class ElementsTable extends Component
{
    use WithPagination;
    protected $listeners = ['refreshElements' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    public function render()
    {
        return view('livewire.tables.elements-table',[
            'elements' => Element::search($this->search)
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
    public function edit(int $elementId)
    {
        $this->emitTo('forms.element-form','editElement',$elementId);
    }
    public function delete(int $elementId)
    {
        $element =Element::findOrFail($elementId);
        if (isset($element->children[0]) ){
            $this->emit('alert',
                ['type' => 'warning',  'message' => 'Element Still Have Children']);
            return back();
        }
        $element->delete();
        $this->emitSelf('refreshElements');
        $this->emit('alert',
            ['type' => 'success',  'message' => 'Element Deleted Successfully!']);
    }
}
