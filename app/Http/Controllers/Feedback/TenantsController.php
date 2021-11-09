<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Http\Requests\TenantCreateRequest;
use App\Models\Feedback\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Stancl\Tenancy\Database\Models\Domain;

class TenantsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tenants = Tenant::with('domains')->get();

        return view('feedback.tenants.index',compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feedback.tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TenantCreateRequest $request
     * @return RedirectResponse
     */
    public function store(TenantCreateRequest $request)
    {
        $validated = $request->safe()->only(['name', 'domain','password']);
        $tenant= Tenant::create([
            'id'=>$validated['name']
        ]);
        $tenant->domains()->create([
            'domain' => $validated['domain'],
        ]);
        Artisan::call('tenants:seed  --tenants='.$tenant->id);
        return redirect()->route('feedback.tenants.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback\Tenant  $tenant
     * @return RedirectResponse
     */
    public function show(Tenant $tenant)
    {
        return view('feedback.tenants.show',compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tenant $tenant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback\Tenant  $tenant
     * @return RedirectResponse
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->deleteOrFail();
        return redirect()->back();
    }
}
