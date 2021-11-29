<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Company;
use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientsController extends Controller
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
        $clients = Client::with('company', 'status')->orderByDesc('id')->paginate('20');
        return view('crm.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = Status::where('type', 'client')->get();
        $companies = Company::where('active', true)->select('id', 'name')->get();
        return view('crm.clients.create', compact('statuses', 'companies'));
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
            'status_id' => 'required|numeric',
             'company_id' => 'nullable'
        ]);
        $input = $request->all();

        Client::create($input);

        toastSuccess('Client Created Successfully');
        return redirect()->route('crm.clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Client $client
     * @return RedirectResponse
     */
    public function show(Client $client)
    {
        return view('crm.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $statuses = Status::where('type', 'client')->get();
        $companies = Company::where('active', true)->select('id', 'name')->get();
        return view('crm.clients.edit', compact('client', 'statuses','companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Client $action
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'status_id' => 'required|numeric',
            'company_id' => 'nullable'
        ]);
        $input = $request->all();

        $client->update($input);
        toastSuccess('Client Updated Successfully');
        return redirect()->route('crm.clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Client $client
     *
     */
    public function destroy(Client $client)
    {
        //  dd($client);
        $client->delete();
        toastSuccess('Client Delete Successfully');
        toastInfo('you can find it in trash later');
        return redirect()->route('crm.clients.index');
    }
}
