<?php

namespace App\Http\Controllers\Formulas;

use App\Http\Controllers\Controller;
use App\Models\Element;
use App\Models\Formula;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FormulasController extends Controller
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
       // $formulas = Formula::orderBy('id','DESC')->paginate(20);
        return view('formulas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

     //   $elements =Element::with(['category'=>fn($q)=>$q->select('id','name')])->get();
        $formula  =null;
        return view('formulas.create',compact('formula'));
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
     * @param  \App\Models\Formula  $formula
     * @return RedirectResponse
     */
    public function show(Formula $formula)
    {
        $formula = Formula::where('id',$formula->id)->with(['elements'=>fn($q)=> $q->with('category'),'category'])->first();
       return view('formulas.show',compact('formula'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function edit(Formula $formula)
    {
        //
      //  return redirect()->route('formulas.create');
        return view('formulas.create',compact('formula'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formula  $formula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Formula $formula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formula  $formula
     * @return RedirectResponse
     */
    public function destroy(Formula $formula)
    {
        if($formula->product){
            toastError('formula still has products');
            return back();
        }
        $formula->deleteOrFail();

        toastSuccess('formula deleted successfully');
        return redirect()->route('formulas.index');
     //   dd($formula);
    }
}
