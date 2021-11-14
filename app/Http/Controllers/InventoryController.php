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
//        $insertItems = ['','',''];
//        $elements = Element::select('id','name')->get();
        return view('inventory.items-insert');
    }
    public function store(ItemsInsertRequest $request)
    {

        $data= $request->all();
        dd($data);
     //   foreach ()
//        $data =   $this->validate($request,[
//             "element_id"    => "required|array",
//             "amount"    => "required|array",
//             "unit"    => "required|array",
//             "expire_at[]"    => "required|array",
//
//            "amount*"  => "required|date|after:today",
//        ]);

    }
    public function accounting ()
    {
        abort(404);
    }

}
