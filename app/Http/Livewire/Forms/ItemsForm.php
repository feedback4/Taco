<?php

namespace App\Http\Livewire\Forms;

use App\Models\Element;
use Livewire\Component;

class ItemsForm extends Component
{

    public function render()
    {

        return view('livewire.forms.items-form',[
            'elements' => Element::select('id','name')->get()
        ]);
    }
}
