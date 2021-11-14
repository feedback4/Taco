<?php

namespace App\Http\Livewire\Forms;

use Livewire\Component;
use \App\Models\Category;

class CategoryForm extends Component
{
    protected $listeners = ['editCategory' => 'edit' ];
    protected $rules = [
       'name' => 'required',
       'type' => 'required',
       'parent_id' => 'nullable|numeric',
   ];

    public $name ;
    public $type ;
    public $parent_id ;
    public $category ;

    public $title = 'create' ;
    public $button = 'create' ;
    public $color = 'success';

    public $types ;

    public function mount()
    {
        $this->types = Category::$types;
    }

    public function render()
    {
        $categories = Category::where('type',$this->type)->whereDoesntHave('parent')->select('id','name')->get();
        return view('livewire.forms.category-form',compact('categories'));
    }

    public  function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public  function save()
    {
        $validated =  $this->validate();


        if ($this->category){
            $this->category->update($validated);
            $this->emit('alert',
                ['type' => 'info',  'message' => 'Category Updated Successfully!']);
        }else{
            if (Category::where('name',$this->name)->exists()){
                $this->emit('alert',
                    ['type' => 'info',  'message' => 'The name has already been taken.']);
                return back();
            }
            $category =  Category::create($validated);
            $this->emit('alert',
                ['type' => 'success',  'message' => 'Category Created Successfully!']);
        }
        $this->emitTo('tables.categories-table','refreshCategories');
        $this->reset(
            'name',
            'type' ,
            'parent_id'
        );

        return back();
    }


    public function edit(int $categoryId)
    {
        // dd($locationId);
        $this->category = \App\Models\Category::where('id', $categoryId)->first();

        $this->name = $this->category->name;
        $this->type = $this->category->type;
        $this->parent_id = $this->category->parent_id;


        $this->title = 'edit';
        $this->button = 'update';
        $this->color = 'primary';
    }
}
