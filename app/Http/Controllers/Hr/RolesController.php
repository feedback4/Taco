<?php

namespace App\Http\Controllers\Hr;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use DB;
use App\Http\Controllers\Controller;
class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:hr');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $roles = Role::whereNotIn('name', ['client'])->orderBy('id','DESC')->paginate(5);

        return view('hr.roles.index',compact('roles'))->with('i',($request->input('page',1)-1)*5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $permissions = Permission::getPermissions();
        return view('hr.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $this->validate($request,[
            'name'=>'required|unique:roles,name',
            'price'=>'required',
            'zone' => '',
            'state' => 'required'
        ]);
        $input = $request->all();

        $role =Role::findOrCreate($request->input('name'));
        $role->syncPermissions($request->input('permissions'));
        return redirect()->route('hr.roles.index')->with('success','Role Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     */
    public function show($id)
    {
        $role = Role::findById($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")->where("role_has_permissions.role_id",$id)->get();
        return view('roles.show',compact('role','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $role = Role::findById($id);
        $permissions = Permission::get();
        $rolePermissions =Db::table("role_has_permissions")->where('role_has_permissions.role_id',$id)->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();
        return view('hr.roles.edit',compact('role','permissions','rolePermissions'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     */
    public function update(Request $request, $id)
    {
        //
        //
        $this->validate($request,[
            'name'=>'required',

        ]);

        $role = Role::find($id);
        // dd($role);

        $role->name =$request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('hr.roles.index')->with('success','Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        DB::table('roles')->where('id',$id)->delete();
        return redirect()->route('hr.roles.index')->with('success','Role Deleted Successfully');
    }

    public function permissions(){
        $permissions = Permission::getPermissions();
        //$roles = Role::
        return view('roles.permissions',compact('permissions'));
    }
    public function permissionsCreate(Request $request){
        $this->validate($request,[
            'name'=>'required|unique:permissions,name',
        ]);
        $input = $request->all();

        // dd($input['name']);
        Permission::create(['name' => $input['name']]);

        return redirect()->back()->with('success','Permission Created Successfully');
    }
    public function permissionsDelete(int $id)
    {
        $permission = Permission::findById($id);
        $permission->delete();
        return redirect()->back()->with('success','Permission Deleted Successfully');
    }
}
