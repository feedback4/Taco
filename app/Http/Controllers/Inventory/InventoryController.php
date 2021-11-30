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
        $pendingItems = Item::doesnthave('inventory')->get();

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
    public function products()
    {
        $inventory = Inventory::where('type','products')->first();
        return view('inventory.index',compact('inventory'));
    }


}
