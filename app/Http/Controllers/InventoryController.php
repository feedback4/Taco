<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemsInsertRequest;
use App\Models\Element;
use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Http\Request;


class InventoryController extends Controller
{
    //
    public function index()
    {
 //   $name = Inventory::whereId($id)->pluck('name')->first();
    //   dd($name);
        return view('inventory.index');
    }
    public function insert()
    {
        //   $name = Inventory::whereId($id)->pluck('name')->first();
        //   dd($name);
        return view('inventory.insert');
    }


}
