<?php

namespace App\Http\Controllers;

use App\Models\Element;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Compound;

class CompoundsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('formulas.compounds.index');
    }


}
