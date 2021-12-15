<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\PriceOffer;
use Illuminate\Http\Request;

class PriceOfferController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:sales');
    }

    public function index()
    {
        return  view('sales.price-offers.index');
    }

    public function create()
    {
        return  view('sales.price-offers.create');
    }

    public function show($id)
    {
        $priceOffer =PriceOffer::with(['products'=>fn($q)=>$q->select('products.id','products.name','products.code','products.last_price')],'client')->findOrFail($id);
        return  view('sales.price-offers.show',compact('priceOffer'));
    }

    public function print($id)
    {
        $priceOffer =PriceOffer::with(['products'=>fn($q)=>$q->select('products.id','products.name','products.code','products.last_price')],'client')->findOrFail($id);
        return  view('vendor.invoices.price-offer',compact('priceOffer'));
    }

    public function destroy($id)
    {
        $priceOffer =PriceOffer::findOrFail($id);
        $priceOffer->delete();
        toastSuccess('Offer Deleted Successfully');
        return redirect()->route('sales.price-offers.index');
    }


}
