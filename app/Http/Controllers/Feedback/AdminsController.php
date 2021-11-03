<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminsController extends Controller
{
    public function dashboard()
    {
        if(Auth::check()){
            return view('feedback.dashboard');
        }

        return redirect("feedback/login")->withSuccess('You are not allowed to access');
    }
}
