<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Multitenancy\Landlord;

class AuthController extends Controller
{
    use AuthenticatesUsers ;

   // protected $redirectTo = '/feedback/login';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('feedback.auth.login');
    }

    public function login(Request $request)
    {
        dd('go');
        $this->validateLogin($request);

//     $o =   DB::connection('landlord')->table('admins')->where('email',$request['email'])->exists();
//     if($o){
//          DB::connection('landlord')->table('admins')->where('email',$request['email'])->select('password');
//         Hash::check('','');
//     }
     //  dd(Hash::make('feedback'));
        dd('go');
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/feedback/dashboard');
        }
        return back()->withInput($request->only('email', 'remember'));


//        $credentials = $request->only('email', 'password');
//        if (Auth::guard('admin')->attempt($credentials)) {
//            return redirect()->intended('/feedback/')->withSuccess('Signed in');
//        }
//
//        return redirect("feedback/login")->withSuccess('Login details are not valid');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
          //  '2fa' => 'required|string',
        ]);
    }


}
