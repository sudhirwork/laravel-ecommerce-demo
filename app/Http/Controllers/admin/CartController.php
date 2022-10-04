<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CartController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:cart-list', ['only' => ['index','getCart']]);
    }

    // index
    public function index()
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['name'=>"Carts"]
        ];

        return view('/admin/cart/cart', ['breadcrumbs' => $breadcrumbs]);
    }

    // get cart
    public function getCart(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');

        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Cart::join('customers', 'carts.id_customer', '=', 'customers.id')->select('count(*) as allcount')->count();
        $totalRecordswithFilter = Cart::join('customers', 'carts.id_customer', '=', 'customers.id')
        ->select('count(*) as allcount')
        ->where(function ($q) use ($searchValue) {
            $q->orWhere('customers.first_name', 'like', "%{$searchValue}%")
            ->orWhere('customers.last_name', 'like', "%{$searchValue}%")
            ->orWhere('carts.name', 'like', "%{$searchValue}%");
        })
        ->count();

        // Fetch records
        $records = Cart::join('customers', 'carts.id_customer', '=', 'customers.id')
            ->orderBy('carts.id', "desc")
            ->where(function ($q) use ($searchValue) {
                $q->orWhere('customers.first_name', 'like', "%{$searchValue}%")
                ->orWhere('customers.last_name', 'like', "%{$searchValue}%")
                ->orWhere('carts.name', 'like', "%{$searchValue}%");
            })
            ->select('carts.id_customer', 'carts.id_product', 'carts.name', 'carts.price', 'carts.quantity', 'carts.subtotal', 'customers.first_name', 'customers.last_name')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = array();
        $counter = 0;
        foreach ($records as $record) {

            $customername = '<a class="text-decoration-none" href="' . route("customerview", [$record["id_customer"]]) . '"><i class="fa-regular fa-eye"></i>&nbsp;'.$record['first_name'].'&nbsp;'.$record['last_name'].'</a>';

            $productname = '<a class="text-decoration-none" href="' . route("productview", [$record["id_product"]]) . '"><i class="fa-regular fa-eye"></i>&nbsp;'.$record['name'].'</a>';

            $price = '<i class="fa-solid fa-indian-rupee-sign"></i>&nbsp;'.$record['price'];

            $quantity = '<span class="badge rounded-pill text-bg-warning">'.$record['quantity'].'</span>';

            $subtotal = '<i class="fa-solid fa-indian-rupee-sign"></i>&nbsp;'.$record['subtotal'];

            $row = array();
            $row[] = ++$counter;

            $row[] = $customername;
            $row[] = $productname;
            $row[] = $price;
            $row[] = $quantity;
            $row[] = $subtotal;

            $data[] = $row;
        }

        $output = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $data,
        );

        echo json_encode($output);
        exit;
    }
}
