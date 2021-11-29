<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    use SoftDeletes;
    public function __construct()
    {
        $this->middleware('permission:hr');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::orderByDesc('id')->paginate('20');;
     return view('hr.employees.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hr.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           'name'=>'required',
            'phone'=>'nullable',
            'salary'=>'nullable|numeric',
            'position'=>'nullable',
            'joined_at'=>'nullable|date',
        ]);
        $input = $request->all();

        Employee::create($input);
        toastSuccess('Employee Created Successfully');
        toastInfo('You Can add him as User');
        return redirect()->route('hr.employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
        return view('hr.employees.show',compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
        return view('hr.employees.edit',compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'nullable',
            'salary'=>'nullable|numeric',
            'position'=>'nullable',
            'joined_at'=>'nullable|date',
        ]);
        $input = $request->all();
        $employee->update($input);
        toastSuccess('Employee Updated Successfully');
        return redirect()->route('hr.employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        if ($employee){
            toastError('Employee Can\'t be Deleted');
            return ;
        }
        $employee->delete();
        toastSuccess('Employee Deleted Successfully');
        return redirect()->route('hr.employees.index');
    }
}
