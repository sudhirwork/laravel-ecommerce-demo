<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerForgot;
use App\Http\Requests\CustomerReset;
use App\Http\Requests\LoginCustomer;
use App\Http\Requests\RegisterCustomer;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class StoreCustomerController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:customer')->except('logout');
    }

    // register form
    public function registerform()
    {
        Session::forget('productid');

        return view('/store/customer/register', ['form' => 'user']);
    }

    // check register form
    public function checkregisterform()
    {
        return view('/store/customer/register', ['form' => 'guest']);
    }

    // register
    public function registercustomer(RegisterCustomer $request)
    {
        if ($files = $request->file('profile_image'))
        {
            if(!File::isDirectory(public_path('customerprofile')))
            {
                File::makeDirectory(public_path('customerprofile'));

                $name = date('YmdHis')."-".str_ireplace(' ', '', $files->getClientOriginalName());
                $files->move('customerprofile', $name);
                $image = $name;
            }
            else
            {
                $name = date('YmdHis')."-".str_ireplace(' ', '', $files->getClientOriginalName());
                $files->move('customerprofile', $name);
                $image = $name;
            }
        }
        else
        {
            $image = '';
        }

        $insertarr = array(
            'profile_image' => $image,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zipcode' => $request->zipcode,
        );

        $customer = Customer::create($insertarr);

        if (Session::has('productid'))
        {
            $productid = Session::get('productid');

            Auth::guard('customer')->loginUsingId($customer->id);

            return response()->json(['success'=>'Customer register successfully.', 'productid' => $productid]);
        }

        Auth::guard('customer')->loginUsingId($customer->id);

        return response()->json(['success'=>'Customer register successfully.', 'productid' => 'blank']);
    }

    // login form
    public function loginform()
    {
        Session::forget('productid');

        return view('/store/customer/login', ['form' => 'user']);
    }

    // check login form
    public function checkloginform()
    {
        return view('/store/customer/login', ['form' => 'guest']);
    }

    // login
    public function logincustomer(LoginCustomer $request)
    {
        $credentials = array(
            'email' => $request->email,
            'password' => $request->password,
        );

        if (Auth::guard('customer')->attempt($credentials))
        {
            if (Session::has('productid'))
            {
                $productid = Session::get('productid');

                $request->session()->regenerate();

                return response()->json(['success'=>'Customer logged in successfully.', 'productid' => $productid]);
            }

            $request->session()->regenerate();

            return response()->json(['success'=>'Customer logged in successfully.', 'productid' => 'blank']);
        }

        return response()->json(['error_login'=>'The provided credentials do not match our records.']);
    }

    // for customer forgot & reset password
    public function forgotcustomerform()
    {
        return view('/store/customer/forgot');
    }

    public function forgotcustomer(CustomerForgot $request)
    {
        $token = Str::random(64);
        $to = $request->email;
        $subject = 'Reset Password';

        $checkdata = DB::table('password_resets')->where('email',$request->email);

        if($checkdata)
        {
            $checkdata->delete();
        }

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $data = [
            'subject' => $subject,
            'email' => $to,
            'token' => $token,
        ];

        Mail::send('mailcustomerforgot', $data, function($message) use ($data) {
            $message->to($data['email'])
            ->subject($data['subject']);
        });

        return response()->json(['success'=>'Your forgot password reset link send in email successfully.']);
    }

    public function customerresetpasswordform($token)
    {
        $email = DB::table('password_resets')->where('token', $token)->first();

        if($email)
        {
            return view('/store/customer/reset', ['token' => $token, 'email' => $email]);
        }
        else
        {
            $msg = 'Your reset password link has been expired, or unknown URL!';

            return Redirect::route('customerresetfail')->with('fail', $msg);
        }
    }

    public function customerresetpassword(CustomerReset $request)
    {
        $updatePassword = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();

        if(!$updatePassword)
        {
            return response()->json(['error_token'=>'Invalid token.']);
        }

        Customer::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return response()->json(['success'=>'Your password has been changed successfully.']);
    }

    public function customerresetfail()
    {
        return view('/store/web/resetfail');
    }

    // for country, state, city get
    public function getcountry(Request $request)
    {
        if($request->searchcountry != '')
        {
            $countries = DB::table('countries')->select('id','name as text')->where('countries.name', 'like', '%' . $request->searchcountry . '%')->orderBy('name', 'asc')->simplePaginate(10);
        }
        else
        {
            $countries = DB::table('countries')->select('id','name as text')->orderBy('name', 'asc')->simplePaginate(10);
        }

        $morePages=true;

        $pagination_obj = json_encode($countries);

        if (empty($countries->nextPageUrl()))
        {
            $morePages=false;
        }

        $results = array(
            "results" => $countries->items(),
            "pagination" => array(
            "more" => $morePages
            )
        );

        return Response::json($results);
    }

    public function getstate(Request $request)
    {
        if($request->searchstate != '')
        {
            $states = DB::table('states')->select('id','name as text')->where('states.country_id',$request->country)->where('states.name', 'like', '%' . $request->searchstate . '%')->orderBy('name', 'asc')->simplePaginate(10);
        }
        else
        {
            $states = DB::table('states')->select('id','name as text')->where('states.country_id',$request->country)->orderBy('name', 'asc')->simplePaginate(10);
        }

        $morePages=true;

        $pagination_obj = json_encode($states);

        if (empty($states->nextPageUrl()))
        {
            $morePages=false;
        }

        $results = array(
            "results" => $states->items(),
            "pagination" => array(
            "more" => $morePages
            )
        );

        return Response::json($results);
    }

    public function getcity(Request $request)
    {
        if($request->searchcity != '')
        {
            $cities = DB::table('cities')->select('id','name as text')->where('cities.state_id',$request->state)->where('cities.name', 'like', '%' . $request->searchcity . '%')->orderBy('name', 'asc')->simplePaginate(10);
        }
        else
        {
            $cities = DB::table('cities')->select('id','name as text')->where('cities.state_id',$request->state)->orderBy('name', 'asc')->simplePaginate(10);
        }

        $morePages=true;

        $pagination_obj = json_encode($cities);

        if (empty($cities->nextPageUrl()))
        {
            $morePages=false;
        }

        $results = array(
            "results" => $cities->items(),
            "pagination" => array(
            "more" => $morePages
            )
        );

        return Response::json($results);
    }

}
