<?php

namespace App\Http\Livewire\Tables;

use App\Models\Bill;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class InvoicesTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderDesc = true;

    public function render()
    {
        return view('livewire.tables.invoices-table',[
            'invoices' => Invoice::search($this->search)
                ->with('client','status')
                //    ->whereHas("roles", function($q){ $q->whereNotIn("name", ["seller"]); })
                ->orderBy($this->orderBy, $this->orderDesc ? 'desc' : 'asc')
                ->paginate($this->perPage),
        ]);
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
}
