<?php

namespace App\Http\Controllers\Purchases;

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
        return view('purchases.vendor.index');
    }
}
