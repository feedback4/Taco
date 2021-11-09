<?php

namespace App\Http\Livewire\Forms;

use App\Models\Category;
use App\Models\Element;
use App\Models\Formula;
use Illuminate\Support\Arr;
use Livewire\Component;


class FormulaForm extends Component
{

    protected $rules = [
        'name' => 'required',
        'code' => 'required',
        'element' => 'nullable',
        'category_id' => 'required|numeric',
        'selectedElements.*' => 'nullable|numeric|min:0|max:100',
    ];

    public $name ;
    public $code ;
    public $element ;
    public $category_id ;
    public $selectedElements ;
    public $activeElements = [] ;
    public $formula;
    public $title = 'create' ;
    public $button = 'create' ;
    public $color = 'success';
    public $searchElements ;
    public $query;

    public function mount()
    {
        $this->query = '';
        $category_id = '';
        $this->searchElements = [];
    }
    public  function updatedQuery()
    {
        $this->searchElements = Element::search($this->query)->with(['category'=>fn($q)=>$q->select('id','name')])->get();
    }
    public function render()
    {
       // $categories = Category::select('id','name')->get();
       // dd($elements);
        return view('livewire.forms.formula-form',[
            'categories' =>  Category::where('type','formula')->select('id','name')->get(),
        ]);
    }

    public  function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public  function updatedSelectedElements()
    {
        $this->resetErrorBag('selectedElements');
     $total = 0 ;
        foreach ($this->selectedElements as $k => $value){
            $total += $value ;

        }
     //   dd($total);
        if ($total > 100){
            $this->addError('selectedElements','total must be equal 100');
        }

    }
    public function add($element)
    {

      //  $element = Element::whereIn($this->element);
        if (!in_array($element,$this->activeElements)){
            $this->activeElements[] =  $element;
        }
       // dd($this->activeElements);
        $this->query = '';
    }
    public function delete($id)
    {
      //  dd($this->activeElements);
        if (($key = array_search($id, $this->activeElements)) !== false) {
            unset($this->activeElements[$key]);
        }
      //  $this->activeElements =  Arr::except($this->activeElements,$id);
     //  $this->emitSelf('$refresh');
     //   unset($this->activeElements[$id]);
    }

    public  function save()
    {
        $validated =  $this->validate();

        $data = [
            'name' =>$validated['name'],
            'code' => $validated['code'],
          'category_id' =>$validated['category_id'],
        //  'selectedElements' => $validated['selectedElements']
        ];

      //  dd($validated);
        if ($this->formula){
            $this->formula->update($data);

            $this->emit('alert',
                ['type' => 'info',  'message' => 'Formula Updated Successfully!']);
        }else{
          $formula =  Formula::create($data);
            foreach ($validated['selectedElements'] as  $k => $value){
                $formula->elements()->attach($k,['amount' => $value ]);
        }

            $this->emit('alert',
                ['type' => 'success',  'message' => 'Formula Created Successfully!']);
        }
        $this->emitTo('tables.formulas-table','refreshFormulas');
        $this->reset(
            'name',
            'code' ,
            'category_id','selectedElements','activeElements'

        );

        return back();
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
