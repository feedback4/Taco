<?php

namespace App\Http\Controllers\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:production');
    }
  public function __invoke()
  {
     return view('production.index');
  }
}
