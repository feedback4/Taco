<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplatesController extends Controller
{
   public function clients ()
   {
       $file = public_path(). "/storage/templates/clients.xlsx";

       $headers = ['Content-Type: application/pdf'];


       if (file_exists($file)) {
           return \Response::download($file, 'clients.xlsx', $headers);
       } else {
           toastError('File not found.');
           return back();
       }

    //   return Storage::download('templates/clients.xlsx');
   }

    public function companies ()
    {
        $file = public_path(). "/storage/templates/companies.xlsx";

       // $headers = ['Content-Type: application/pdf'];

        if (file_exists($file)) {
            return \Response::download($file, 'companies.xlsx');
        } else {
            toastError('File not found.');
            return back();
        }


   //     return Storage::download('templates/companies.xlsx');
    }

    public function vendors ()
    {
        $file = public_path() . "/storage/templates/vendors.xlsx";
        if (file_exists($file)) {
            return \Response::download($file, 'vendors.xlsx');
        } else {
            toastError('File not found.');
            return back();
        }
    }
    public function elements ()
    {
        $file = public_path() . "/storage/templates/elements.xlsx";
        if (file_exists($file)) {
            return \Response::download($file, 'elements.xlsx');
        } else {
            toastError('File not found.');
            return back();
        }
    }
    public function items ()
    {
        $file = public_path() . "/storage/templates/items.xlsx";
        if (file_exists($file)) {
            return \Response::download($file, 'items.xlsx');
        } else {
            toastError('File not found.');
            return back();
        }
    }
    public function products ()
    {
        $file = public_path() . "/storage/templates/products.xlsx";
        if (file_exists($file)) {
            return \Response::download($file, 'products.xlsx');
        } else {
            toastError('File not found.');
            return back();
        }
    }
}
