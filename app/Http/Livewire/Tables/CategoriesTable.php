<?php

namespace App\Http\Livewire\Tables;

use App\Models\Category;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use function PHPUnit\Framework\isEmpty;

class CategoriesTable extends Component
{
    use WithPagination;
    protected $listeners = ['refreshCategories' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderDesc = true;


    public function render()
    {
        return view('livewire.tables.categories-table', [
            'categories' => Category::search($this->search)
                ->with('parent')
                //    ->whereHas("roles", function($q){ $q->whereNotIn("name", ["seller"]); })
                ->orderBy($this->orderBy, $this->orderDesc ? 'desc' : 'asc')
                ->paginate($this->perPage),
        ]);

    }
    public function updatedPerPage()
    {
        $this->resetPage();
    }
    public function edit(int $categoryId)
    {
        $this->emitTo('forms.category-form','editCategory',$categoryId);
    }
    public function delete(int $categoryId)
    {
        $category =         Category::findOrFail($categoryId);
        if (isset($category->children[0]) ){
            $this->emit('alert',
                ['type' => 'warning',  'message' => 'Category Still Have Children']);
        return back();
        }
        $category->delete();
        $this->emitSelf('refreshCategory');
        $this->emit('alert',
            ['type' => 'success',  'message' => 'Category Deleted Successfully!']);
    }

}
