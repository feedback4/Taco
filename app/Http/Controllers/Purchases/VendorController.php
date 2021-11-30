<?php

namespace App\Http\Controllers\Purchases;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:purchases');
    }
    public function index()
    {
        $vendors =Vendor::paginate(20);
        return view('purchases.vendors.index',compact('vendors'));
    }
    public function create(){
        return view('purchases.vendors.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
            'email'=>'nullable',
            'address'=>'required',
        ]);
        $input = $request->all();
      //  dd($input);
        Vendor::create($input);
        toastSuccess('Vendor Created Successfully');

        return redirect()->route('purchases.vendors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
        return view('hr.vendors.show',compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        //
        return view('purchases.vendors.edit',compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
            'email'=>'nullable',
            'address'=>'required',
        ]);
        $input = $request->all();
        $vendor->update($input);
        toastSuccess('Vendor Updated Successfully');
        return redirect()->route('purchases.vendors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        if ($vendor->bills){
            toastError('Vendor Can\'t be Deleted');
            return  back();
        }
        $vendor->delete();
        toastSuccess('Vendor Deleted Successfully');
        return redirect()->route('purchases.vendors.index');
    }

}
