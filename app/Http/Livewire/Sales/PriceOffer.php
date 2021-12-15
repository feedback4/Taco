<?php

namespace App\Http\Livewire\Sales;

use App\Models\Client;
use App\Models\Item;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PriceOffer extends Component
{
    use AuthorizesRequests;

    protected $listeners= ['selectProduct'];
    public $searchClients = [];
    public $query = '';

    public $client,$offerProducts=[] ,$cost=[],$offered_at,$notes;

    public function mount()
    {
        $this->offered_at = now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.sales.price-offer');
    }

    public function updatedQuery()
    {
        $this->searchClients = Client::search($this->query)->take(5)->get();
    }

    public function selectClient($id)
    {
        $this->client = Client::with('company')->find($id);
    }

    public function clearClient()
    {
        $this->reset('client');
    }

    public function selectProduct($id)
    {
        // $product = Product::find($id);
        $product = Product::find($id);
        $this->offerProducts[] = ['name' => $product->name .' ('. $product->code.')','product_id' => $product->id, 'description' => '', 'cost' => 0,'last_price' => $product->last_price, 'price' => 0];
        $this->cal();
    }

//    public function createProduct()
//    {
//        $this->offerProducts[] = ['name' => '','product_id' => 0, 'description' => '', 'quantity' => 1, 'price' => 0];
//    }

    public function deleteProduct($index)
    {
        unset($this->offerProducts[$index]);
        unset($this->cost[$index]);
        $this->cal();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    private function cal()
    {
       if ($this->offerProducts){

           foreach ($this->offerProducts as $k => $prod){
               $cost = 0 ;
               $product = Product::with(['formula'=>fn($q)=>$q->with('elements')])->find($prod['product_id'])  ;
               foreach ( $product->formula->elements as $element ){
                   $cost += Item::where('element_id',$element->id)->latest()->first()->price * $element->pivot->amount /100 ;
               }
               $this->offerProducts[$k]['cost'] = $cost;
           }
       }
    }
    public function export()
    {
        dd('export');
    }

    public function save()
    {
        if (!$this->client){
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Please Select or Create Client']);
            return back();
        }
        if (!$this->offerProducts){
            $this->emit('alert',
                ['type' => 'error', 'message' => 'Please Select at least one Product']);
            return back();
        }
        $validated = $this->validate();


        $data = [
            'offered_at' =>$this->offered_at ,
            'client_id' => $this->client->id,
            'user_id' => auth()->id()
        ];

        $offer = \App\Models\PriceOffer::create($data);
        foreach ($this->offerProducts as $product) {
            $offer->products()->attach($product['product_id'], ['price' => floatval($product['price'])+0  ]);
        }


        $this->emit('alert',
            ['type' => 'success', 'message' => 'Price Offer Created Successfully!']);
        $this->emit('alert',
            ['type' => 'info', 'message' => 'You can print or export it']);
        return redirect()->route('sales.price-offers.index');
    }

    protected function rules()
    {
        return [
            'offered_at' => 'required|date',
            'notes' => 'nullable',


            'offerProducts.*.name' => 'required',
            'offerProducts.*.description' => 'nullable',
//            'offerProducts.*.quantity' => 'required|numeric|min:0|max:10000',
            'offerProducts.*.cost' => 'required|numeric|min:0',
            'offerProducts.*.price' => 'required|numeric|min:0',
        ];
    }

}
