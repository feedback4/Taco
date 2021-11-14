<?php

namespace App\Http\Livewire\Forms;

use App\Models\Category;
use App\Models\Element;
use App\Models\Formula;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Livewire\Component;


class FormulaForm extends Component
{
    use AuthorizesRequests;



    public $name;
    public $code;
    public $category_id;
    public $activeQategories = [];
    //  public  $elements;
    public $formula;
    public $title = 'create';
    public $button = 'create';
    public $color = 'success';
    public $searchCategory = [];
    public $query = '';
    public $g = false;
    public $total = 0;

    public function mount($formula =null){
        $this->authorize('formula-create');
        if($formula){
            $this->formula = $formula;
            $this->name =   $this->formula->name;
            $this->code =   $this->formula->code;
            $this->category_id =   $this->formula->category_id;
            $total = 0;
            foreach ($this->formula->categories as $cat){
                $total +=  $cat->pivot->amount ;
            }
            if ($total > 100) {
                $this->g = true;
                foreach ($this->formula->categories as $cat){
                    $this->activeQategories[] = ['category' => $cat->id, 'g' =>$cat->pivot->amount, 'per' => 0];
                }
            }else{
                foreach ($this->formula->categories as $cat){
                    $this->activeQategories[] = ['category' => $cat->id, 'g' =>0, 'per' => $cat->pivot->amount];
                }
            }
            $this->title = 'edit';
            $this->button = 'update';
            $this->color = 'primary';
            $this->cal();
        }
    }
    public function updatedQuery()
    {
        $this->searchCategory = Category::search($this->query)->with('elements')->take(6)->get();
    }

    public function render()
    {
        return view('livewire.forms.formula-form', [
            'categories' => Category::where('type', 'formula')->select('id', 'name')->get(),
        ]);
    }

    private function cal(): bool
    {
        $this->resetErrorBag('activeQategories');
        $total = 0;
        foreach ($this->activeQategories as $k => $value) {
            if ($value['g'] < 0 || $value['per'] < 0) {
                $this->total = 0;
                return 0;
            }
            if ($this->g) {
                $total += $value['g'];
            } else {
                $total += $value['per'];
            }
        }
        $result = 1;
        if ($this->g) {
            if ($total > 1000) {
                $this->addError('activeQategories', 'total must be equal 1000 g.');
                $result = 0;
            }
        } else {
            if ($total > 100) {
                $result = 0;
                $this->addError('activeQategories', 'total must be equal 100%');
            }
        }
        $this->total = $total;
        return $result;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedActiveQategories()
    {
        $this->cal();
    }

    public function updatedG()
    {
        $this->cal();
    }

    public function add($cate)
    {
        foreach ($this->activeQategories as $ele) {
            if (array_search($cate, $ele)) {
                $this->emit('alert',
                    ['type' => 'waring', 'message' => 'Element Already Exists!']);
                return;
            }
        }
        $this->activeQategories[] = ['category' => $cate, 'g' => 0, 'per' => 0];
        //    dd(    $this->activeQategories);
        $this->query = '';
    }

    public function removeProduct($index)
    {
        unset($this->activeQategories[$index]);
        $this->activeQategories = array_values($this->activeQategories);
        $this->cal();
    }

    public function filler()
    {
        $category = Category::whereName('filler')->first()?->id;
        foreach ($this->activeQategories as $ele) {
            if (array_search($category, $ele)) {
                $this->emit('alert',
                    ['type' => 'waring', 'message' => 'Element Already Exists!']);
                return;
            }
        }
        $amount = $this->g ? 1000 - $this->total : 100 - $this->total;

        $this->activeQategories[] = $this->g ? ['category' => $category, 'g' => $amount, 'per' => 0] : ['category' => $category, 'g' => 0, 'per' => $amount];
        $this->cal();
    }

    public function save()
    {
        if (!$this->cal()) {
            $this->emit('alert',
                ['type' => 'info', 'message' => 'يا جدع مينفعش']);
            return;
        }
        $this->authorize('formula-create');
        $validated = $this->validate();

        $data = [
            'name' => $validated['name'],
            'code' => $validated['code'],
            'category_id' => $validated['category_id'],
            //  'activeQategories' => $validated['activeQategories']
        ];

        //  dd($validated);
        if ($this->formula) {
            $this->formula->update($data);
            $this->formula->categories()->detach();
            foreach ($validated['activeQategories'] as $k => $ele) {
                $amount = $this->g ? $ele['g'] : $ele['per'];
                $this->formula->categories()->attach($ele['category'], ['amount' => $amount]);
            }
            $this->emit('alert',
                ['type' => 'info', 'message' => 'Formula Updated Successfully!']);
        } else {
            $formula = Formula::create($data);

            foreach ($validated['activeQategories'] as $k => $ele) {
                $amount = $this->g ? $ele['g'] : $ele['per'];
                $formula->categories()->attach($ele['category'], ['amount' => $amount]);
            }

            $this->emit('alert',
                ['type' => 'success', 'message' => 'Formula Created Successfully!']);
        }
        //    $this->emitTo('tables.formulas-table','refreshFormulas');
        $this->reset('name', 'code', 'category_id', 'activeQategories','total');

        return back();
    }
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

    protected function rules()
    {
        return [
            'name' =>[ 'required',Rule::unique('formulas')->ignore($this->formula?->id)],
            'code' => [ 'required',Rule::unique('formulas')->ignore($this->formula?->id)],
            'category_id' => 'required|numeric',
            'activeQategories.*.category' => 'nullable|numeric',
            'activeQategories.*.g' => 'required|numeric|min:0|max:1000',
            'activeQategories.*.per' => 'required|numeric|min:0|max:100',
        ];
    }
}
