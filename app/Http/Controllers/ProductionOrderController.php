<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ProductionOrder;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PDF;


class ProductionOrderController extends Controller
{
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
        //   dd($order->item->element);
        //  $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML('<h1>Test</h1>');
//        return $pdf->stream();

        //   view()->share('order',$order);
        $pdf = PDF::loadView('vendor.invoices.pdf',['order'=>$order ] );
        return $pdf->stream();
        return $pdf->download('test.pdf');
        // share data to view

        // download PDF file with download method
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductionOrder  $productionOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductionOrder $productionOrder)
    {
        //

        $order =   ProductionOrder::whereId($id)->with(['items'=>fn($q)=>$q->with('element')])->first();


        $invoice = \ConsoleTVs\Invoices\Classes\Invoice::make()
            //   ->items($order->items)
            ->addItem('Test Item 2', 5, 2, 923)
            ->addItem('Test Item 3', 15.55, 5, 42)
//            ->addItem('Test Item 4', 1.25, 1, 923)
//            ->addItem('Test Item 5', 3.12, 1, 3142)
//            ->addItem('Test Item 6', 6.41, 3, 452)
//            ->addItem('Test Item 7', 2.86, 1, 1526)
//            ->addItem('Test Item 8', 5, 2, 923)
            ->number(4021)
            ->with_pagination(true)
            ->duplicate_header(true)
            ->due_date(Carbon::now()->addMonths(1))
            ->notes('Lrem ipsum dolor sit amet, consectetur adipiscing elit.')
            ->customer([
                'name'      => 'Èrik Campobadal Forés',
                'id'        => '12345678A',
                'phone'     => '+34 123 456 789',
                'location'  => 'C / Unknown Street 1st',
                'zip'       => '08241',
                'city'      => 'Manresa',
                'country'   => 'Spain',
            ]);

        $invoice->download('demo');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductionOrder  $productionOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductionOrder $productionOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductionOrder  $productionOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductionOrder $productionOrder)
    {
        //
    }
}
