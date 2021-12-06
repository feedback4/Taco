<?php

namespace App\Http\Livewire\Forms;

use App\Models\Compound;
use App\Models\Element;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CompoundsForm extends Component
{
    use AuthorizesRequests;
    protected $listeners = ['editCompound' => 'edit' ];
    public $name;
    public $code;
    public  $activeElements = [['element' => '', 'percent' => 0], ['element' => '', 'percent' => 0]];
    public $total = 0;
    public $compound;
    public $title = 'Create' ;
    public $button = 'Create' ;
    public $color = 'success';



    public function render()
    {
        return view('livewire.forms.compounds-form',[
            'elements' =>  Element::with(['category' => fn($q) => $q->select('id', 'name')])->get()
        ]);
    }

    public function addElement()
    {
//        foreach ($this->activeElements as $ele) {
//            if (array_search($element, $ele)) {
//                $this->emit('alert',
//                    ['type' => 'waring', 'message' => 'Element Already Exists!']);
//                return;
//            }
//        }
        foreach ($this->activeElements as $ele) {
            $ids[] = $ele['element'];
        }
        $this->activeElements[] = ['element' => '', 'percent' => 0];
        //    dd(    $this->activeElements);
    }

    public function removeElement($index)
    {
        unset($this->activeElements[$index]);
        $this->activeElements = array_values($this->activeElements);
    }
    public function enter()
    {
        $this->cal();
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function updatedActiveElements()
    {

        $this->cal();
    }

    private function cal(): bool
    {
        $this->resetErrorBag('activeElements');
        $total = 0;

        foreach ($this->activeElements as $k => $value) {
            if ($value['percent'] < 0) {
                $this->total = 0;
                return 0;
            }
            $total += $value['percent'];
        }
     //   dd(floatval($total));
        $result = false;
            if (floatval($total) > 100 ) {
                $this->addError('activeElements', 'total must be equal 100%');
            }
        $this->total = $total;
      if (number_format($total,2) == 100.00){
          $result = true;
      }

        return $result;
    }

    public function save()
    {
        if (!$this->cal()) {
            $this->emit('alert',
                ['type' => 'info', 'message' => 'يا جدع مينفعش']);
            return back();
        }
        $this->authorize('formula-create');
        $validated = $this->validate();

        $data = [
            'name' => $validated['name'],
            'code' => $validated['code'],
        ];

        if ($this->compound) {
            $this->compound->update($data);
            $this->compound->elements()->detach();
            foreach ($validated['activeElements'] as $k => $ele) {
                if ($ele['percent']) {
                    $this->compound->elements()->attach($ele['element'], ['percent' => floatval($ele['percent'])]);
                }
            }
            $this->emit('alert',
                ['type' => 'info', 'message' => 'Compound Updated Successfully!']);
        } else {
            $compound = Compound::create($data);

            foreach ($validated['activeElements'] as $k => $ele) {
                if ($ele['percent']){
                    $compound->elements()->attach($ele['element'], ['percent' => floatval($ele['percent'])  ]);
                }
            }

            $this->emit('alert',
                ['type' => 'success', 'message' => 'Compound Created Successfully!']);
        }
            $this->emitTo('tables.compounds-table','refreshCompounds');
        $this->reset();

        return back();
    }
    public function edit(int $compoundId)
    {
        // dd($locationId);
        $this->compound = Compound::where('id', $compoundId)->with('elements')->first();

        $this->name = $this->compound->name;
        $this->code = $this->compound->code;
        $this->activeElements = [];
        foreach ($this->compound->elements as $element) {
            $this->activeElements[] = ['element' =>$element->id, 'percent' => $element->pivot->percent];
        }

        $this->title = 'Edit';
        $this->button = 'Update';
        $this->color = 'primary';
        $this->cal();
    }
    protected function rules()
    {
        return [
            'name' => ['required', Rule::unique('compounds')->ignore($this->compound?->id)],
            'code' => ['required', Rule::unique('compounds')->ignore($this->compound?->id)],

            'activeElements.*.element' => ['required','numeric',
             //   Rule::notIn($ids)
            ],
            'activeElements.*.percent' => 'required|numeric|min:0|max:100',
        ];
    }
}
