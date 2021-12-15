<?php

namespace App\Http\Controllers\Production;

use App\Models\Client;
use App\Models\Item;
use App\Models\Product;
use App\Models\ProductionOrder;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PDF;
use App\Http\Controllers\Controller;

class ProductionOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:production');
    }
    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse
     */
    public function index()
    {
        return view('production.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('production.create');
    }

    public function print($id)
    {
        $order =   ProductionOrder::whereId($id)->with(['items'=>fn($q)=>$q->with(['element','inventory']),'formula','user'])->first();
        return view('vendor.invoices.inventory',compact('order'));
     //   dd($order->item->element);
      //  $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML('<h1>Test</h1>');
//        return $pdf->stream();

     //   view()->share('order',$order);
        $pdf = PDF::loadView('vendor.invoices.production',['order'=>$order ] );
        return $pdf->stream();
        return $pdf->download('test.pdf');


        // share data to view

        // download PDF file with download method
    }

    public function pdf($id)
    {
        $order =   ProductionOrder::whereId($id)->with(['items'=>fn($q)=>$q->with(['element','inventory']),'formula','user'])->first();
        return view('vendor.invoices.production',compact('order'));
        //   dd($order->item->element);
        //  $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML('<h1>Test</h1>');
//        return $pdf->stream();

        //   view()->share('order',$order);
//        $products = Product::all();
//        $client= Client::first();




//        $pdf = PDF::loadView('vendor.invoices.price-offer',['products'=>$products,'client'=>$client ] );
//        return $pdf->stream();
//
//        $pdf = PDF::loadView('vendor.invoices.pdf',['order'=>$order ] );;
//        return $pdf->stream();
//        return $pdf->download('test.pdf');
        // share data to view

        // download PDF file with download method
    }

    /**
     * Display the specified resource.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {

        $order = ProductionOrder::whereId($id)->with('formula','user','items')->first();

        return view('production.show',compact('order'));
    }

    public function done($id)
    {
        $productionOrder =  ProductionOrder::with(['formula' => fn($q)=> $q->with('product','elements')],'items')->findOrFail($id);
        $cost = 0;

       foreach ($productionOrder->items as $item){
           $cost +=  $item->pivot->amount;
       }

        return view('production.done',compact('productionOrder','cost'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        //
        $productionOrder =   ProductionOrder::whereId($id)->with(['items'])->first();

        return view('production.edit',compact('productionOrder'));
    }

    public function destroy( $id)
    {
        $productionOrder = ProductionOrder::findOrFail($id) ;
        $productionOrder->items()->delete();
        $productionOrder->delete();
        toastSuccess('Production Order Deleted Successfully');
        return redirect()->route('production.index');
    }

}
