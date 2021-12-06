<?php

namespace App\Http\Livewire\Tables;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentsTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderDesc = true;

    public function render()
    {
        return view('livewire.tables.payments-table',[
            'payments' => Payment::search($this->search)
                ->with('vendor','bill')
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
