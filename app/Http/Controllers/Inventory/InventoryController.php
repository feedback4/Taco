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
 //   $name = Inventory::whereId($id)->pluck('name')->first();
    //   dd($name);
        return view('inventory.index');
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


}
