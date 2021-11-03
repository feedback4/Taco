<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Models\Feedback\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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

   //     $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    public function index()
    {
        return view('feedback.auth.login');
    }


    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
//     $o =   DB::connection('landlord')->table('admins')->where('email',$request['email'])->exists();
//     if($o){
//          DB::connection('landlord')->table('admins')->where('email',$request['email'])->select('password');
//         Hash::check('','');
//     }
     //  dd(Hash::make('feedback'));



        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/feedback/a');
        }
        return back()->withInput($request->only('email', 'remember'));


//        $credentials = $request->only('email', 'password');
//        if (Auth::guard('admin')->attempt($credentials)) {
//            return redirect()->intended('/feedback/')->withSuccess('Signed in');
//        }
//
//        return redirect("feedback/login")->withSuccess('Login details are not valid');
    }



    public function register()
    {
        return view('feedback.auth.register');
    }


    public function customRegistration(Request $request)
    {
       // dd($this->tenantDatabaseConnectionName());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:Admins',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();


        $check = $this->create($data);

        return redirect("feedback/dashboard")->withSuccess('You have signed-in');
    }


    public function create(array $data)
    {
      //  Landlord::execute(fn () => Artisan::call('migrate:fresh --path=database/migrations/landlord --database=landlord --seed'));

        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function signOut() {
        Session::flush();
        Auth::guard('admin')->logout();

        return Redirect('feedback.login');
    }
}
