<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CustomerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:customer-list|customer-delete|customer-view', ['only' => ['index','getCustomer','customerdestroy','customerview']]);
        $this->middleware('permission:customer-list', ['only' => ['index','getCustomer']]);
        $this->middleware('permission:customer-delete', ['only' => ['customerdestroy']]);
        $this->middleware('permission:customer-view', ['only' => ['customerview']]);
    }

    // index
    public function index()
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['name'=>"Customers"]
          ];

          return view('/admin/customer/customer', ['breadcrumbs' => $breadcrumbs]);
    }

    // get customer
    public function getCustomer(Request $request)
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
        $totalRecords = Customer::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Customer::select('count(*) as allcount')
        ->where(function ($q) use ($searchValue) {
            $q->orWhere('first_name', 'like', "%{$searchValue}%")
            ->orWhere('last_name', 'like', "%{$searchValue}%");
        })
        ->count();

        // Fetch records
        $records = Customer::orderBy('customers.id', "desc")
            ->where(function ($q) use ($searchValue) {
                $q->orWhere('customers.first_name', 'like', "%{$searchValue}%")
                ->orWhere('customers.last_name', 'like', "%{$searchValue}%");
            })
            ->select('customers.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = array();
        $counter = 0;
        foreach ($records as $record) {
            $row = array();
            $row[] = ++$counter;

            $row[] = $record['first_name'].' '.$record['last_name'];
            $row[] = $record['email'];
            $row[] = $record['mobile'];

            $Action = '';

            if(Auth::user()->can('customer-view'))
            {

                $Action .= '<a href="' . route("customerview", [$record["id"]]) . '"><i class="fa-regular fa-eye"></i></a>&nbsp;&nbsp;&nbsp;';

            }

            if(Auth::user()->can('customer-delete'))
            {

                $Action .= '<a data-id="' . $record["id"] . '"  href="javascript:;" class="deleteRecord"><i class="fa-regular fa-trash-can"></i></a>&nbsp;&nbsp;&nbsp;';

            }

            $row[] = $Action;
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

    // destroy or delete
    public function customerdestroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json([
            'success' => 'Record deleted successfully!',
        ]);
    }

    // show
    public function customerview($id)
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['link'=>"admin/customer",'name'=>"Customers"], ['name'=>"View Customer"]
        ];

        $customer = Customer::findOrFail($id);

        $city = DB::table('cities')->where('id',$customer->city)->first();
        $state = DB::table('states')->where('id',$customer->state)->first();
        $country = DB::table('countries')->where('id',$customer->country)->first();

        return view('/admin/customer/customerview', ['breadcrumbs' => $breadcrumbs, 'customer' => $customer, 'city' => $city, 'state' => $state, 'country' => $country]);
    }
}
