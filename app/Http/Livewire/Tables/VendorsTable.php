<?php

namespace App\Http\Livewire\Tables;

use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithPagination;

class VendorsTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderDesc = true;

    public function render()
    {
        return view('livewire.tables.vendors-table',[
            'vendors' => Vendor::search($this->search)
                ->with('bills')
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
