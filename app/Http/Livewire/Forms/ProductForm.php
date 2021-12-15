<?php

namespace App\Http\Livewire\Forms;

use App\Models\Category;
use App\Models\Formula;
use App\Models\Product;
use Livewire\Component;

class ProductForm extends Component
{
    protected $listeners = ['editProduct' => 'edit' ];
    protected $rules = [
        'name' => 'required',
        'code' => 'required',
        'formula_id' => 'required|numeric',
        'category_id' => 'required|numeric',
        'texture' => 'nullable',
        'gloss' => 'nullable',
        'color_family' => 'nullable',
        'curing_time' => 'nullable',
        'last_price' => 'nullable|numeric|min:0',
    ];

    public $name ;
    public $code ;
    public $formula_id ;
    public $category_id ;
    public $texture ;
    public $gloss ;
    public $color_family ;
    public $curing_time;
    public $last_price ;

    public $product;

    public $title = 'create' ;
    public $button = 'create' ;
    public $color = 'success';


    public function render()
    {
        return view('livewire.forms.product-form',[
            'categories' => Category::where('type','product')->select('id','name')->get(),
            'formulas' => Formula::select('id','name','code')->get(),
             'textures' => Product::$textures
        ]);
    }

    public  function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public  function save()
    {
        $validated =  $this->validate();

        if ($this->product){
            $this->product->update($validated);
            $this->emit('alert',
                ['type' => 'info',  'message' => 'Product Updated Successfully!']);
        }else{
            if (Product::where('code',$this->code)->exists()){
                $this->emit('alert',
                    ['type' => 'info',  'message' => 'The code has already been taken.']);
                return back();
            }
            $product =  Product::create($validated);
            $this->emit('alert',
                ['type' => 'success',  'message' => 'Product Created Successfully!']);
        }
        $this->emitTo('tables.products-table','refreshProducts');
        $this->reset();

        return back();
    }


    public function edit(int $productId)
    {
        // dd($locationId);
        $this->product = Product::where('id', $productId)->first();

        $this->name = $this->product->name;
        $this->code = $this->product->code;
        $this->formula_id = $this->product->formula_id;
        $this->category_id = $this->product->category_id;
        $this->texture = $this->product->texture;
        $this->gloss = $this->product->gloss;
        $this->color_family = $this->product->color_family;
        $this->curing_time = $this->product->curing_time;
        $this->last_price = $this->product->last_price;

        $this->title = 'edit';
        $this->button = 'update';
        $this->color = 'primary';
    }
}
