<?php

namespace App\Http\Livewire\Forms;

use App\Models\Category;
use App\Models\Compound;
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
    public $activeElements = [];
    public $compound;
    public $percent = 0;
    public $formula;
    public $title = 'create';
    public $button = 'create';
    public $color = 'success';
    public $searchElements = [];
    public $query = '';
    public $g = false;
    public $total = 0;
    public $filler;

    public function mount($formula = null)
    {
        $this->authorize('formula-create');

        if ($formula) {
            $this->formula = $formula;
            $this->name = $this->formula->name;
            $this->code = $this->formula->code;
            $this->category_id = $this->formula->category_id;
            $total = 0;
            foreach ($this->formula->elements as $elem) {
                $total += $elem->pivot->amount;
            }
            if ($total > 100) {
                $this->g = true;
                foreach ($this->formula->elements as $elem) {
                    $this->activeElements[$elem->id] = ['name' =>$elem->name .' -- '. $elem->code,'g' => $elem->pivot->amount, 'per' => $elem->pivot->amount /10];
                }
            } else {
                foreach ($this->formula->elements as $elem) {
                    $this->activeElements[$elem->id] = ['name' =>$elem->name .' -- '. $elem->code, 'g' => $elem->pivot->amount *10, 'per' => $elem->pivot->amount];
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

        $this->searchElements = Element::search($this->query)->with('category')->take(6)->get();
    }

    public function render()
    {
        return view('livewire.forms.formula-form', [
            'categories' => Category::where('type', 'formula')->select('id', 'name')->get(),
            'fillers' => Element::whereHas('category', fn($q) => $q->where('categories.name', 'filler'))->get(),
            'compounds' => Compound::with('elements')->get(),
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedActiveElements()
    {
        $this->cal();
    }

    public function updatedG()
    {

        $this->cal();
    }

    public function addElement($element)
    {
        foreach ($this->activeElements as $ele) {
            if (isset($this->activeElements[$element])) {
                $this->emit('alert',
                    ['type' => 'error', 'message' => 'Element Already Exists!']);
                return back();
            }
        }
        $elem = Element::findOrFail($element);
        $this->activeElements[$element] = ['name' =>$elem->name .' -- '. $elem->code, 'g' => 0, 'per' => 0];
        $this->query = '';

    }

    public function removeElement($index)
    {
        unset($this->activeElements[$index]);
  //      $this->activeElements ;
        $this->cal();
    }
    public function addCompound()
    {
        if (!$this->compound){
            $this->emit('alert',
                ['type' => 'info', 'message' => 'Please Select Compound']);
            return back();
        }

        if (!$this->percent){
            $this->emit('alert',
                ['type' => 'info', 'message' => 'Compound percent cannot be 0']);
            return back();
        }
        $elements = Compound::find($this->compound)->elements;
        foreach ($elements as $elem){
            $amount = $elem->pivot->percent * $this->percent / 100;
            $this->activeElements[$elem->id] = ['name' =>$elem->name .' -- '. $elem->code ,'g' => $amount *10, 'per' => $amount];
        }
        $this->cal();
    }

    public function filler()
    {
        if ($this->g) {
            if ($this->total > 1000) {
                session()->flash('message', 'Please lower the percentage');
                return back();
            }
        } else {
            if ($this->total > 100) {
                session()->flash('message', 'Please lower the percentage');

                return back();
            }
        }
        if (!$this->filler) {
            $this->emit('alert',
                ['type' => 'info', 'message' => 'Please Select A Filler']);
            return back();
        }
    //    $elements = Element::whereHas('category', fn($q) => $q->where('categories.name', 'filler'))->pluck('id');
        $filler = Element::findOrFail($this->filler);
        foreach ($this->activeElements as $ele) {
//            foreach ($elements as $fillElement) {
//                if (array_search($fillElement, $ele)) {
//                    session()->flash('message', 'Another filler Already Exists!');
//                    return back();
//                }
//            }
            if (isset($this->activeElements[$filler->id])) {

                $this->emit('alert',
                    ['type' => 'error', 'message' => 'Element Already Exists!']);
                return back();
            }
        }


        $amount = $this->g ? ((1000 - $this->total) / 10) : (100 - $this->total);

        $this->activeElements[$filler->id] = ['name' =>$filler->name .' -- '. $filler->code ,'g' => $amount * 10, 'per' => number_format($amount,2)];
        $this->cal();
    }

    private function cal(): bool
    {
        $this->resetErrorBag('activeElements');
        $total = 0;
        if (!$this->g) {
            foreach ($this->activeElements as $k => $ele) {
                $this->activeElements[$k]['g'] = $this->activeElements[$k]['per'] * 10;
            }
        } else {
            foreach ($this->activeElements as $k => $ele) {
                $this->activeElements[$k]['per'] = $this->activeElements[$k]['g'] / 10;
            }
        }
        foreach ($this->activeElements as $k => $value) {
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
                $this->addError('activeElements', 'total must be equal 1000 g.');
                $result = 0;
            }
        } else {
            if ($total > 100) {
                $result = 0;
                $this->addError('activeElements', 'total must be equal 100%');
            }
        }

        $this->total = $total;
        return $result;
    }

    public function save()
    {
        if (!$this->activeElements) {
            $this->emit('alert',
                ['type' => 'info', 'message' => 'Please Select Some Elements First']);
            return;
        }
        if (!$this->cal()) {
            $this->emit('alert',
                ['type' => 'info', 'message' => 'Something went wrong']);
            return;
        }
        $this->authorize('formula-create');
        $validated = $this->validate();

        $data = [
            'name' => $validated['name'],
            'code' => $validated['code'],
            'category_id' => $validated['category_id'],
        ];

        if ($this->formula) {
            $this->formula->update($data);
            $this->formula->elements()->detach();
            foreach ($validated['activeElements'] as $k => $ele) {
                $this->formula->elements()->attach($k , ['amount' => floatval($ele['per']) ]);
            }
            $this->emit('alert',
                ['type' => 'info', 'message' => 'Formula Updated Successfully!']);
        } else {
            $formula = Formula::create($data);

            foreach ($validated['activeElements'] as $k => $ele) {
                $formula->elements()->attach($k, ['amount' => floatval($ele['per'])]);
            }

            $this->emit('alert',
                ['type' => 'success', 'message' => 'Formula Created Successfully!']);
        }
        //    $this->emitTo('tables.formulas-table','refreshFormulas');
        $this->reset();

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
            'name' => ['required'],
            'code' => ['required', Rule::unique('formulas')->ignore($this->formula?->id)],
            'category_id' => 'nullable|numeric',
            'filler' => 'nullable|numeric',
            'compound' => 'nullable|numeric',
            'percent' => 'nullable|numeric|min:0|max:100',
            'activeElements.*.element_id' => 'nullable|distinct|numeric',
            'activeElements.*.g' => 'required|numeric|min:0|max:1000',
            'activeElements.*.per' => 'required|numeric|min:0|max:100',
        ];
    }
}
