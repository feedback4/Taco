<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
  public function __invoke()
  {
     return view('production.index');
  }
}
