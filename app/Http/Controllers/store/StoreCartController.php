<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Productimage;
use App\Models\Cart;
use Illuminate\Http\Request;

class StoreCartController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:customer']);
    }

    // for cart item list
    public function index($id)
    {
        $carts = Cart::join('products', 'carts.id_product', '=', 'products.id')
        ->orderBy('carts.id', "desc")
        ->where('carts.id_customer', $id)
        ->select('carts.quantity', 'carts.subtotal', 'carts.id_customer', 'carts.id as cartid', 'carts.id_product', 'products.*')
        ->get();

        $count = $carts->count();

        $total = $carts->sum('subtotal');

        return view('/store/cart/cart', ['carts' => $carts, 'count' => $count, 'total' => $total]);
    }

    // for cart quantity change
    public function qtyUpdate(Request $request)
    {
        $cart = Cart::findOrFail($request->id);

        $cart->update([
            'quantity' => $request->quantity,
            'subtotal' => $cart['price'] * $request->quantity,
        ]);

        echo $cart->subtotal;
    }

    // cart item destroy or delete
    public function cartitemdestroy($id)
    {
        $cartitem = Cart::findOrFail($id);
        $cartitem->delete();

        return response()->json([
            'success' => 'Cart Item deleted successfully!',
        ]);
    }

    // whole cart items destroy or delete
    public function wholecartitemdestroy($id)
    {
        Cart::where('id_customer', $id)->delete();

        return response()->json([
            'success' => 'Cart Empty successfully!',
        ]);
    }
}
