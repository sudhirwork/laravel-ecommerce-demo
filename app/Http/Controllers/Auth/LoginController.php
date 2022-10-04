<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function adminauthenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $userstatuscheck = User::where('email', $request->email)->where('status', '0')->get();
        $countstatuscheck = $userstatuscheck->count();

        if ($countstatuscheck == 0)
        {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->intended('admin/dashboard');
            }
        }
        else
        {
            return back()->withErrors([
                'email' => 'This email is currently inactive, please contact administrator.',
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function forgotpassword(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
        ]);

        if ($credentials)
        {
            $user = User::where('email',$request->email)->first();

            if ($user != null)
            {
                $ran = Str::random(8);
                $to = $request->email;
                $subject = 'Forgot Password';

                $data = [
                    'subject' => $subject,
                    'email' => $to,
                    'password' => $ran,
                ];

                Mail::send('mailforgot', $data, function($message) use ($data) {
                $message->to($data['email'])
                ->subject($data['subject']);
                });

                $user = User::find($user->id);

                $updatearr = array(
                    'password' => Hash::make($ran),
                );

                $user->update($updatearr);

                return Redirect::route('login')->with('success', 'Your New Password Send In Your Register E-Mail Successfully');
            }
            else
            {
                return back()->withErrors([
                    'email' => 'The provided E-Mail do not match our records.',
                ]);
            }
        }
    }

    // Login
    public function showLoginForm()
    {
        return view('/auth/login');
    }

    // Forgot
    public function forgot()
    {
        return view('/auth/forgot');
    }
}
