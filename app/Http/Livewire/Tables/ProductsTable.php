<?php

namespace App\Http\Livewire\Tables;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsTable extends Component
{

    use WithPagination;
    protected $listeners = ['refreshProducts' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderDesc = true;

    public function render()
    {
        return view('livewire.tables.products-table',[
            'products' => Product::search($this->search)
                ->with('formula')
                //    ->whereHas("roles", function($q){ $q->whereNotIn("name", ["seller"]); })
                ->orderBy($this->orderBy, $this->orderDesc ? 'desc' : 'asc')
                ->paginate($this->perPage),
        ]);
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
    public function edit(int $productId)
    {
        $this->emitTo('forms.product-form','editProduct',$productId);
    }
    public function delete(int $productId)
    {
        $product =Product::findOrFail($productId);
//        if (isset($product->children[0]) ){
//            $this->emit('alert',
//                ['type' => 'warning',  'message' => 'Pro Still Have Children']);
//            return back();
//        }
        $product->delete();
        $this->emitSelf('refreshProducts');
        $this->emit('alert',
            ['type' => 'success',  'message' => 'Product Deleted Successfully!']);
    }
}
