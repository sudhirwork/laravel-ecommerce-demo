<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceOrder;
use App\Models\Product;
use App\Models\Productimage;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Paymentdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class StoreOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:customer']);
    }

    // for checkout items list
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        $carts = Cart::join('products', 'carts.id_product', '=', 'products.id')
        ->orderBy('carts.id', "desc")
        ->where('carts.id_customer', $customer->id)
        ->select('carts.quantity', 'carts.subtotal', 'carts.id_customer', 'carts.id as cartid', 'carts.id_product', 'products.*')
        ->get();

        $count = $carts->count();

        $total = $carts->sum('subtotal');

        $country = DB::table('countries')->find($customer->country);
        $state = DB::table('states')->find($customer->state);
        $city = DB::table('cities')->find($customer->city);

        return view('/store/order/order', ['carts' => $carts, 'count' => $count, 'total' => $total, 'customer' => $customer, 'country' => $country, 'state' => $state, 'city' => $city]);
    }

    // for place order
    public function placeorder(PlaceOrder $request)
    {
        foreach ($request->addmore as $key => $value)
        {
            $insertarr = array(
                'id_customer' => $request->customerid,
                'id_product' => $value['id_product'],
                'order_no' => $value['code'].'-'.rand(00000, 99999).''.$request->customerid.''.$value['subtotal'],
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
                'name' => $value['name'],
                'brand' => $value['brand'],
                'code' => $value['code'],
                'price' => $value['price'],
                'quantity' => $value['quantity'],
                'subtotal' => $value['subtotal'],
            );

            $order = Order::create($insertarr);

            $cart = Cart::findOrFail($value['id_cart']);
            $cart->delete();

            $product = Product::findOrFail($order->id_product);

            $product->update([
                'stock_quantity' => $product['stock_quantity'] - $order->quantity,
            ]);

            $insertpaymentarr = array(
                'id_customer' => $request->customerid,
                'id_order' => $order->id,
                'ref_no' => $request->pm.''.$order->id.'-'.rand(000000, 999999).'-'.$request->customerid.''.rand(000, 999),
                'payment_method' => $request->pm,
                'total' => $order->subtotal, // $request->total
            );

            Paymentdetail::create($insertpaymentarr);
        }

        return response()->json(['success'=>'Your order placed successfully.']);
    }

    // for select2 state, country, city
    public function getallcountry(Request $request)
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

    public function getallstate(Request $request)
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

    public function getallcity(Request $request)
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
