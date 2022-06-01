<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemsInsertRequest;
use App\Models\Element;
use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Http\Request;


class InventoryController extends Controller
{
    public function __construct()
    {

        $this->middleware('permission:inventory');
    }

    public function index()
    {
        $inventory = Inventory::first();
        return view('inventory.index',compact('inventory'));
    }
    public function transfer()
    {
        $inventories = Inventory::select('id','name','type')->get();
        dd($inventories);
        return view('inventory.transfer',compact('inventories'));
    }
    public function show($id)
    {
       $inventory = Inventory::findOrFail($id);
        return view('inventory.show',compact('inventory'));
    }
    public function insert($id)
    {

        return view('inventory.insert',compact('id'));
    }
    public function pending()
    {
        $pendingItems = Item::where('type','material')->doesnthave('inventory')->orderByDesc('id')->get();

        return view('inventory.pending',compact('pendingItems'));
    }
    public function add(Request $request)
    {

       $this->validate($request,[
          'items' => 'array'
       ]);
       if (!$request->items){
           toastError('Pleas Select some items to move');
           return back();
       }

       foreach ($request->items as $id){
          $item = Item::find($id) ;
          $item->inventory_id = 1;
          $item->update();
       }
       toastSuccess('Items added to Inventory successfully');
       return redirect()->route('inventory.index');
    }

    public function production ()
    {
        $inventory = Inventory::where('name','production')->first();
        return view('inventory.production',compact('inventory'));
    }
    public function productionPending()
    {
        $inventory = Inventory::where('name','production')->first();
        $pendingItems = Item::where('type','product')->doesnthave('inventory')->get();

        return view('inventory.production-pending',compact('pendingItems'));
    }

    public function addProduction(Request $request)
    {

        $this->validate($request,[
            'items' => 'array'
        ]);
        if (!$request->items){
            toastError('Pleas Select some items to move');
            return back();
        }

        foreach ($request->items as $id){
            $item = Item::find($id) ;
            $item->inventory_id = 2;
            $item->update();
        }
        toastSuccess('Items added to Inventory successfully');
        return redirect()->route('inventory.products');
    }

    public function products()
    {
        $inventory = Inventory::where('type','products')->first();
        return view('inventory.products',compact('inventory'));
    }

    public function productsPending()
    {
        $pendingItems = Item::where('type','product')->doesnthave('inventory')->get();

        return view('inventory.products-pending',compact('pendingItems'));
    }

    public function addProducts(Request $request)
    {

        $this->validate($request,[
            'items' => 'array'
        ]);
        if (!$request->items){
            toastError('Pleas Select some items to move');
            return back();
        }

        foreach ($request->items as $id){
            $item = Item::find($id) ;
            $item->inventory_id = 2;
            $item->update();
        }
        toastSuccess('Items added to Inventory successfully');
        return redirect()->route('inventory.products');
    }


}
