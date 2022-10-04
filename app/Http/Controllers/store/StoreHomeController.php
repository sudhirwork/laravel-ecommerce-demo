<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreHomeController extends Controller
{
    public function index()
    {
        $product1 = Product::join('categories', 'products.id_category', '=', 'categories.id')
        ->where('products.status', '1')
        ->where('categories.status', '1')
        ->select('products.*', 'categories.name as categoryname')
        ->where('products.stock_quantity', '!=', 0)
        ->latest()
        ->first();

        $products = Product::join('categories', 'products.id_category', '=', 'categories.id')
        ->where('products.status', '1')
        ->where('categories.status', '1')
        ->select('products.*', 'categories.name as categoryname')
        ->where('products.stock_quantity', '!=', 0)
        ->latest()
        ->take(10)
        ->get();

        return view('/store/home', ['products' => $products, 'product1' => $product1]);
    }
}
