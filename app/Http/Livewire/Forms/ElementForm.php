<?php

namespace App\Http\Livewire\Forms;

use App\Models\Category;
use App\Models\Element;
use Livewire\Component;

class ElementForm extends Component
{
    protected $listeners = ['editElement' => 'edit' ];
    protected $rules = [
        'name' => 'required',
        'code' => 'required',
        'category_id' => 'required|numeric',
    ];

    public $name ;
    public $code ;
    public $category_id ;
    public $element;

    public $title = 'create' ;
    public $button = 'create' ;
    public $color = 'success';


    public function render()
    {
        $categories = Category::where('type','element')->select('id','name')->get();
        return view('livewire.forms.element-form',compact('categories'));
    }

    public  function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public  function save()
    {
        $validated =  $this->validate();

        if ($this->element){
            $this->element->update($validated);
            $this->emit('alert',
                ['type' => 'info',  'message' => 'Element Updated Successfully!']);
        }else{
            if (Element::where('name',$this->name)->exists()){
                $this->emit('alert',
                    ['type' => 'info',  'message' => 'The name has already been taken.']);
                return back();
            }
            $category =  Element::create($validated);
            $this->emit('alert',
                ['type' => 'success',  'message' => 'Element Created Successfully!']);
        }
        $this->emitTo('tables.elements-table','refreshElements');
        $this->reset(
            'name',
            'code' ,
            'category_id'
        );

        return back();
    }


    public function edit(int $elementId)
    {
        // dd($locationId);
        $this->element = Element::where('id', $elementId)->first();

        $this->name = $this->element->name;
        $this->code = $this->element->code;
        $this->category_id = $this->element->category_id;


        $this->title = 'edit';
        $this->button = 'update';
        $this->color = 'primary';
    }
}
