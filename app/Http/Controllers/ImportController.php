<?php

namespace App\Http\Controllers;

use App\Imports\ClientsImporter;
use App\Imports\CompaniesImporter;
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
        Excel::import(new ClientsImporter(), $request->file('vendors')->store('temp'));
        toastSuccess('Done ....');
        return back();
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileExport()
    {
     //   return Excel::download(new UsersExport, 'users-collection.xlsx');
    }

}
