<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePassword;
use App\Http\Requests\CustomerProfileUpdate;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class StoreAuthenticatedController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:customer']);
    }

    // for customer profile view
    public function customerprofile()
    {
        $customer = Auth::guard('customer')->user();

        $country = DB::table('countries')->find($customer->country);
        $state = DB::table('states')->find($customer->state);
        $city = DB::table('cities')->find($customer->city);

        return view('/store/customer/customerprofile', ['customer' => $customer, 'country' => $country, 'state' => $state, 'city' => $city]);
    }

    // for customer profile edit
    public function customerprofileedit()
    {
        $customer = Auth::guard('customer')->user();

        $country = DB::table('countries')->find($customer->country);
        $state = DB::table('states')->find($customer->state);
        $city = DB::table('cities')->find($customer->city);

        return view('/store/customer/customerprofileedit', ['customer' => $customer, 'country' => $country, 'state' => $state, 'city' => $city]);
    }

    // for customer profile update
    public function customerprofileupdate(CustomerProfileUpdate $request)
    {
        $customer = Customer::find(Auth::guard('customer')->user()->id);
        $customers = Customer::find(Auth::guard('customer')->user()->id);

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
                $path = public_path().'/customerprofile/';

                // for remove old profile image
                if($customers->profile_image != ''  && $customers->profile_image != null && !empty($customers->profile_image))
                {
                    $file_old = $path.$customers->profile_image;

                    if(File::exists($file_old))
                    {
                        unlink($file_old);
                    }
                }

                $name = date('YmdHis')."-".str_ireplace(' ', '', $files->getClientOriginalName());
                $files->move('customerprofile', $name);
                $image = $name;
            }
        }
        else
        {
            $image = $customers->profile_image;
        }

        $updatearr = array(
            'profile_image' => $image,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zipcode' => $request->zipcode,
        );

        $customer->update($updatearr);

        return response()->json(['success'=>'Profile updated successfully.']);
    }

    // for change password
    public function changepassword()
    {
        return view('/store/customer/changepassword');
    }

    public function changeingpassword(ChangePassword $request)
    {
        Customer::find(Auth::guard('customer')->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return response()->json(['success'=>'Your password changed successfully.']);
    }

    // for order items list
    public function myorder()
    {
        $customer = Auth::guard('customer')->user();

        $order1 = Order::join('products', 'orders.id_product', '=', 'products.id')
        ->orderBy('orders.id', "desc")
        ->where('orders.id_customer', $customer->id)
        ->select('orders.*', 'products.thumbnail')
        ->first();

        $orders = Order::join('products', 'orders.id_product', '=', 'products.id')
        ->orderBy('orders.id', "desc")
        ->where('orders.id_customer', $customer->id)
        ->select('orders.*', 'products.thumbnail')
        ->get();

        // $country = DB::table('countries')->find($orders->country);
        // $state = DB::table('states')->find($orders->state);
        // $city = DB::table('cities')->find($orders->city);

        return view('/store/customer/myorder', ['orders' => $orders, 'customer' => $customer, 'order1' => $order1]);
    }
}
