<?php

namespace App\Http\Controllers\Formulas;
use App\Http\Controllers\Controller;
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
        $this->middleware('permission:formulas');
        return view('formulas.compounds.index');
    }


}
