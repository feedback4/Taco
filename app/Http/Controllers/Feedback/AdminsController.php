<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function dashboard()
    {
        return view('feedback.dashboard');
    }
    public function index()
    {
        $admins = Admin::all();
        return view('feedback.admins.index',compact('admins'));
    }
    public function invite()
    {
        return view('feedback.admins.invite');
    }
    public function show( $id)
    {
        $admin = Admin::whereId($id)->with('roles')->first();

        return view('feedback.admins.show',compact('admin'));
    }
    public function send(Request $request)
    {
        dd($request->all());
        return redirect()->back();
    }

    public function logout() {
        Session::flush();
        Auth::guard('admin')->logout();

        return Redirect('feedback/login');
    }
}
