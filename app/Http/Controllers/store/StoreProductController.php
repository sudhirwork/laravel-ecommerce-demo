<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Productimage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StoreProductController extends Controller
{
    // for product list
    public function index($value)
    {
        if ($value == 'list')
        {
            $category = 'All';

            $data = Product::orderBy('id', "desc")->where('status', '1')->where('stock_quantity', '!=', 0)->paginate(12);
        }
        else
        {
            $categorydata = Category::findOrFail($value);

            $category = $categorydata->name;

            $data = Product::orderBy('id', "desc")->where('id_category', $value)->where('status', '1')->where('stock_quantity', '!=', 0)->paginate(12);
        }

        return view('/store/product/product', ['data' => $data, 'value' => $value, 'category' => $category]);
    }

    public function getProduct(Request $request, $value)
    {
        if($request->ajax())
        {
            if ($request->price == 'desc')
            {
                if ($value == 'list')
                {
                    $data = Product::orderBy('price', "desc")->where('status', '1')->where('stock_quantity', '!=', 0)->paginate(12);
                }
                else
                {
                    $data = Product::orderBy('price', "desc")->where('id_category', $value)->where('status', '1')->where('stock_quantity', '!=', 0)->paginate(12);
                }
            }
            elseif ($request->price == 'asc')
            {
                if ($value == 'list')
                {
                    $data = Product::orderBy('price', "asc")->where('status', '1')->where('stock_quantity', '!=', 0)->paginate(12);
                }
                else
                {
                    $data = Product::orderBy('price', "asc")->where('id_category', $value)->where('status', '1')->where('stock_quantity', '!=', 0)->paginate(12);
                }
            }
            else
            {
                if ($value == 'list')
                {
                    $data = Product::orderBy('id', "desc")->where('status', '1')->where('stock_quantity', '!=', 0)->paginate(12);
                }
                else
                {
                    $data = Product::orderBy('id', "desc")->where('id_category', $value)->where('status', '1')->where('stock_quantity', '!=', 0)->paginate(12);
                }
            }

            return view('/store/product/components/productarea', compact('data'))->render();
        }
    }

    // for product details
    public function productdetails($id)
    {
        $product = Product::findOrFail($id);

        $productimages = Productimage::where('id_project', $product->id)->get();

        return view('/store/product/productdetail', ['product' => $product, 'productimages' => $productimages]);
    }

    // for product add to cart
    public function addtocart(Request $request)
    {
        if (Auth::guard('customer')->check())
        {
            $cartproduct = Cart::where('id_customer', Auth::guard('customer')->user()->id)->where('id_product', $request->id)->first();

            if ($cartproduct)
            {
                $cart = Cart::findOrFail($cartproduct->id);

                $qty = $cart->quantity + 1;
                $subtotal = $cart->price * $qty;

                $cart->update([
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ]);

                echo 0;
            }
            else
            {
                $insertarr = array(
                    'id_customer' => Auth::guard('customer')->user()->id,
                    'id_product' => $request->id,
                    'name' => $request->name,
                    'brand' => $request->brand,
                    'code' => $request->code,
                    'price' => $request->price,
                    'quantity' => 1,
                    'subtotal' => $request->price,
                );

                Cart::create($insertarr);

                echo 1;
            }
        }
        else
        {
            Session::put('productid', $request->id);

            echo 2;
        }
    }
}
