<?php

namespace App\Http\Livewire\Forms;

use App\Models\Category;
use App\Models\Element;
use App\Models\Formula;
use Livewire\Component;


class FormulaForm extends Component
{

    protected $rules = [
        'name' => 'required',
        'code' => 'required',
        'element' => 'nullable',
        'category_id' => 'required|numeric',
        'element.*' => 'nullable',
        'amount.*' => 'nullable'
    ];

    public $name ;
    public $code ;
    public $element = [] ;
    public $elements;
    public $category_id ;
//    public $formula ;
    public $activeElements = [] ;
//    public $title = 'create' ;
//    public $button = 'create' ;
//    public $color = 'success';

    public function render()
    {
       // $categories = Category::select('id','name')->get();
        $this->elements = Element::with(['category'=>fn($q)=>$q->select('id','name')])->get();
       // dd($elements);
        return view('livewire.forms.formula-form',[
            'categories' =>  Category::where('type','formula')->select('id','name')->get(),
        ]);
    }

//    public  function updated($propertyName)
//    {
//        $this->validateOnly($propertyName);
//    }

    public function add()
    {
      //  $element = Element::whereIn($this->element);
//        if (!in_array($element,$this->activeElements)){
//            $this->activeElements[] =  $element;
//        }
        dd($this->element);


    }
    public function delete($id)
    {
        dd($id);
        $this->activeElements =  array_except($id,$this->activeElements);
        $this->emitSelf('$refresh');
        unset($this->activeElements[$i]);
    }

    public  function save()
    {
        $validated =  $this->validate();
        dd($validated);
//        if ($this->formula){
//            $this->formula->update($validated);
//            $this->emit('alert',
//                ['type' => 'info',  'message' => 'Formula Updated Successfully!']);
//        }else{
//            if (Formula::where('name',$this->name)->exists()){
//                $this->emit('alert',
//                    ['type' => 'info',  'message' => 'The name has already been taken.']);
//                return back();
//            }
//
//            $formula =  Formula::create($validated);
//            $this->emit('alert',
//                ['type' => 'success',  'message' => 'Formula Created Successfully!']);
//        }
//        $this->emitTo('tables.formulas-table','refreshFormulas');
//        $this->reset(
//            'name',
//            'code' ,
//            'category_id'
//        );
//
//        return back();
    }
//
//
//    public function edit(int $formulaId)
//    {
//        // dd($locationId);
//        $this->formula = Formula::where('id', $formulaId)->first();
//
//        $this->name = $this->formula->name;
//        $this->code = $this->formula->code;
//        $this->category_id = $this->formula->category_id;
//
//
//        $this->title = 'edit';
//        $this->button = 'update';
//        $this->color = 'primary';
//    }
}
