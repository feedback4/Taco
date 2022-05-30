<?php

namespace App\Http\Controllers;

use App\Exports\ProductsInventoryExporter;
use App\Imports\ClientsImporter;
use App\Imports\CompaniesImporter;
use App\Imports\ElementsImporter;
use App\Imports\ItemsImporter;
use App\Imports\VendorsImporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
         return view('import');
    }


    public function clients(Request $request)
    {
        $this->validate($request ,[
            'clients'          => 'required|mimes:xlsx',
        ]);
        Excel::import(new ClientsImporter(), $request->file('clients')->store('temp'));
        toastSuccess('Done ....');
        return back();
    }

    public function companies(Request $request)
    {

        $this->validate($request ,[
            'companies'          => 'required|mimes:xlsx',
        ]);

        Excel::import(new CompaniesImporter(), $request->file('companies')->store('temp'));

        toastSuccess('Done ....');
        return back();
    }

    public function vendors(Request $request)
    {

         $this->validate($request ,[
            'vendors'          => 'required|mimes:xlsx',
        ]);
       // dd( $request->file('vendors'));
        Excel::import(new VendorsImporter(), $request->file('vendors')->store('temp'));

        toastSuccess('Done ....');
        return back();
    }
    public function elements(Request $request)
    {

        $this->validate($request ,[
            'elements'          => 'required|mimes:xlsx',
        ]);
        // dd( $request->file('vendors'));
        Excel::import(new ElementsImporter(), $request->file('elements')->store('temp'));

        toastSuccess('Done ....');
        return back();
    }
    public function items(Request $request)
    {

        $this->validate($request ,[
            'items'          => 'required|mimes:xlsx',
        ]);
        // dd( $request->file('vendors'));
        Excel::import(new ItemsImporter(), $request->file('items')->store('temp'));

        toastSuccess('Done ....');
        return back();
    }
    public function products(Request $request)
    {

        $this->validate($request ,[
            'products'          => 'required|mimes:xlsx',
        ]);
        // dd( $request->file('vendors'));
        Excel::import(new ProductsInventoryExporter(), $request->file('products')->store('temp'));

        toastSuccess('Done ....');
        return back();
    }


}
