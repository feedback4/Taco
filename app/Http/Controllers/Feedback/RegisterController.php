<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FAQRCode\Google2FA;

class RegisterController extends Controller
{
    use RegistersUsers {
        // change the name of the name of the trait's method in this class
        // so it does not clash with our own register method
        register as registration;
    }
    use ValidatesRequests;

    //  use Google2F
    protected $redirectTo = '/feedback';

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

        $google2fa = new Google2FA();

        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        $data = $request->all();
        // Add the secret key to the registration data
        $data["google2fa_secret"] = $google2fa->generateSecretKey();
        //dd($data["google2fa_secret"]);
        // Save the registration data to the user session for just the next request
        $request->session()->flash('registration_data', $data);
        //      dd($data);
        // Generate the QR image. This is the image the user will scan with their app
        // to set up two factor authentication
        //   $google2fa->setAllowInsecureCallToGoogleApis(true);
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $data['email'],
            $data['google2fa_secret']
        );


        // $check = $this->create($data);
        // Pass the QR barcode image to our view
        return view('feedback.auth.google2fa', ['QR_Image' => $QR_Image, 'secret' => $data['google2fa_secret']]);

        //      return redirect("feedback/dashboard")->withSuccess('You have signed-in');
    }

    public function completeRegistration(Request $request)
    {
        $request->validate([
            '_token' => 'required'
        ]);
        $data = session('registration_data');
        //   dd($data);
        //       dd(session('registration_data'));
        // add the session data back to the request input
        $request->merge(session('registration_data'));
        // $this->create(session('registration_data'));

        // Call the default laravel authentication
        return $this->regis($request);
    }

    public function create(array $data)
    {
        //  Landlord::execute(fn () => Artisan::call('migrate:fresh --path=database/migrations/landlord --database=landlord --seed'));

        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'google2fa_secret' => $data['google2fa_secret'],
        ]);
    }

    public function reauthenticate(Request $request)
    {
        // get the logged in user
        $user = Auth::user();

        // initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        // generate a new secret key for the user
        $user->google2fa_secret = $google2fa->generateSecretKey();

        // save the user
        $user->save();

        // generate the QR image
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        // Pass the QR barcode image to our view.
        return view('google2fa.register', ['QR_Image' => $QR_Image,
            'secret' => $user->google2fa_secret,
            'reauthenticating' => true
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins.email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /*
    * Handle a registration request for the application.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    */
    public function regis(Request $request)
    {
//        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectTo);
    }

    protected function guard()
    {
        return Auth::guard('admin');

    }
}
