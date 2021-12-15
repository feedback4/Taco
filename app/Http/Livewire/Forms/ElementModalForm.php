<?php

namespace App\Http\Livewire\Forms;

use App\Models\Category;
use App\Models\Element;
use Livewire\Component;

class ElementModalForm extends Component
{
    protected $rules = [
        'name' => 'required',
        'code' => 'required|unique:elements',
        'category_id' => 'required|numeric',
        'last_price' => 'nullable|numeric|min:0',
    ];

    public $name ;
    public $code ;
    public $category_id ;
    public $last_price ;

    public $element;

    public $updateMode = false;

    public function render()
    {
        return view('livewire.forms.element-modal-form',[
            'categories' => Category::where('type','element')->select('id','name')->get()
        ]);
    }

    public  function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function open()
    {
        $this->updateMode = true;
    }
    public function close()
    {
        $this->updateMode = false;
        $this->dispatchBrowserEvent('closeModel');
    }

    public function save()
    {
        $validated =  $this->validate();
        $this->element =   Element::create($validated);

        $this->emitTo('forms.bill-form','selectItem',$this->element->id);
        $this->dispatchBrowserEvent('closeModel');
    }
}
