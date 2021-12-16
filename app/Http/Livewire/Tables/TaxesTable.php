<?php

namespace App\Http\Livewire\Tables;

use App\Models\Tax;
use Livewire\Component;
use Livewire\WithPagination;

class TaxesTable extends Component
{
    use WithPagination;
    protected $listeners = ['refreshTaxes' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderDesc = true;

    public function render()
    {
        return view('livewire.tables.taxes-table',[
            'taxes' => Tax::search($this->search)
                //    ->whereHas("roles", function($q){ $q->whereNotIn("name", ["seller"]); })
                ->orderBy($this->orderBy, $this->orderDesc ? 'desc' : 'asc')
                ->paginate($this->perPage),
        ]);
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
    public function edit(int $taxId)
    {
        $this->emitTo('forms.tax-form','editTax',$taxId);
    }
    public function delete(int $taxId)
    {
        $tax =Tax::findOrFail($taxId);
        if (isset($tax->invoices[0]) ||  isset($tax->bills[0])){
            $this->emit('alert',
                ['type' => 'warning',  'message' => 'Tax Still Used in Bills or Invoices']);
            return back();
        }
        $tax->delete();
        $this->emitSelf('refreshTaxes');
        $this->emit('alert',
            ['type' => 'success',  'message' => 'Tax Deleted Successfully!']);
    }
}
