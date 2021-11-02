<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;


class UsersController extends Controller
{
    use SoftDeletes;
    public function __construct()
    {
        $this->middleware('permission:user-show|user-create|user-edit|user-delete',['only'=>['index','show']]);
        $this->middleware('permission:user-create',['only'=>['create','store']]);
        $this->middleware('permission:user-edit',['only'=>['update','edit']]);
        $this->middleware('permission:user-delete',['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param UsersDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        $users = User::with(['roles'=>fn($q)=>$q->select('id','name')])->orderBy('id','DESC')->paginate(5);
        // $roleId = DB::table('roles')->where('name',$request->input('role'))->value('id');


      return view('users.index',compact('users'));
     //   dd($dataTable);
     //  return $dataTable->render('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
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
        $this->validate($request,[
            'name'=>'required',
            'email'=> 'required|email|unique:users,email',
            'role'=>'required',
            'password'=> 'required',

        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('role'));
        toastSuccess('yaaaah');
        return redirect()->route('users.index')->with('success','User Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = User::findOrFail($id);
        $userRole = DB::table('roles')->where('id',$user->role)->get();

        if(! $user->hasAnyRole(Role::all())) {
            $user->assignRole('customer');
        }
        $roles = $user->getRoleNames();
        return view('users.show',compact('user','roles','userRole'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id)
    {
        //
        $user = User::findOrFail($id);
        $roles =Role::pluck('name')->all();
        $userRole = $user->roles->pluck('name')->all();

        return view('users.edit',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=> 'required|email',
            'role'=>'required'
        ]);
        $input = $request->all();
        $user =  User::findOrFail($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $roleId = DB::table('roles')->where('name',$request->input('role'))->value('id');

        DB::table('users')->where('id',$id)->update(['role'=>$roleId]);
        $user->assignRole($request->input('role'));
        return redirect()->route('users.index')->with('success','User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success','User Deleted Successfully');
    }
}
