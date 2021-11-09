<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
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

    public function logout() {
        Session::flush();
        Auth::guard('admin')->logout();

        return Redirect('feedback/login');
    }
}
