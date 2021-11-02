<?php

namespace App\Http\Livewire\Main;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ToggleButton extends Component
{
    public Model $model;
    public string $field;
    public bool $isActive;

    public function mount()
    {
        $this->isActive = (bool) $this->model->getAttribute($this->field);
    }
    public function render()
    {
        return view('livewire.main.toggle-button');
    }
    public function updating($field, $value)
    {
        $this->model->setAttribute($this->field,$value)->save();
        $this->emit('alert',
            ['type' => 'success',  'message' => 'Updated Successfully!']);
    }
}
