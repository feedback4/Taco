<?php

namespace App\Http\Controllers\Formulas;
use App\Http\Controllers\Controller;
use App\Models\Element;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Compound;

class ElementsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:formulas');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     //   $elements = Element::orderBy('id','DESC')->paginate(20);
        return view('formulas.elements.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\CategoriesController
     */
    public function create()
    {
        //
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
        $element = Element::whereId($id)->with(['formulas'=>fn($q)=> $q->with('category'),'category'])->first();
       return view('formulas.elements.show',compact('element'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Element  $element
     * @return \Illuminate\Http\Response
     */
    public function edit(Element $element)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Element  $element
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Element $element)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Element  $element
     * @return \Illuminate\Http\Response
     */
    public function destroy(Element $element)
    {
        //
    }

}
