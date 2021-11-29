<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:crm');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::with('clients')->orderByDesc('id')->paginate('20');
        return view('crm.companies.index',compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = User::$states;
        return view('crm.companies.create',compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'nullable',
            'state' => 'required',
            'address' => 'nullable'
        ]);
        $input = $request->all();

        Company::create($input);

        toastSuccess('Company Created Successfully');
        return redirect()->route('crm.companies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Company $company
     * @return RedirectResponse
     */
    public function show(Company $company)
    {
        return view('crm.companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $states = User::$states;
        return view('crm.companies.edit', compact('company','states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $action
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'nullable',
            'state' => 'required',
            'address' => 'nullable'
        ]);
        $input = $request->all();

        $company->update($input);

        toastSuccess('Company Updated Successfully');
        return redirect()->route('crm.companies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company $company
     *
     */
    public function destroy(Company $company)
    {
        $company->delete();
        toastSuccess('Company Delete Successfully');
        toastInfo('you can find it in trash later');
        return redirect()->route('crm.companies.index');
    }

}
