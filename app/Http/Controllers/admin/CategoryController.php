<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:category-list|category-add|category-edit|category-delete|category-view', ['only' => ['index','getCategory','categorycreate','categorystore','categoryedit','categoryupdate','categorydestroy','categoryview','getCategoryProduct']]);
        $this->middleware('permission:category-list', ['only' => ['index','getCategory']]);
        $this->middleware('permission:category-add', ['only' => ['categorycreate','categorystore']]);
        $this->middleware('permission:category-edit', ['only' => ['categoryedit','categoryupdate']]);
        $this->middleware('permission:category-delete', ['only' => ['categorydestroy']]);
        $this->middleware('permission:category-view', ['only' => ['categoryview', 'getCategoryProduct']]);
        $this->middleware('permission:product-list', ['only' => ['getCategoryProduct']]);
    }

    // index
    public function index()
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['name'=>"Categories"]
          ];

          return view('/admin/category/category', ['breadcrumbs' => $breadcrumbs]);
    }

    // get category
    public function getCategory(Request $request)
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
        $totalRecords = Category::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Category::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Category::orderBy('categories.id', "desc")
            ->where('categories.name', 'like', '%' . $searchValue . '%')
            ->select('categories.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = array();
        $counter = 0;
        foreach ($records as $record) {

            if($record['status'] == '1')
            {
                $status = '<span class="badge rounded-pill text-bg-success">Active</span>';
            }
            else
            {
                $status = '<span class="badge rounded-pill text-bg-danger">Inactive</span>';
            }

            $row = array();
            $row[] = ++$counter;

            $row[] = $record['name'];

            $row[] = $status;

            $Action = '';

            if(Auth::user()->can('category-edit'))
            {

                $Action .= '<a href="' . route("categoryedit", [$record["id"]]) . '"><i class="fa-regular fa-pen-to-square"></i></a>&nbsp;&nbsp;&nbsp;';

            }

            if(Auth::user()->can('category-view'))
            {

                $Action .= '<a href="' . route("categoryview", [$record["id"]]) . '"><i class="fa-regular fa-eye"></i></a>&nbsp;&nbsp;&nbsp;';

            }

            if(Auth::user()->can('category-delete'))
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

    // create
    public function categorycreate()
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['link'=>"admin/category",'name'=>"Categories"], ['name'=>"Add Category"]
        ];

        return view('/admin/category/categoryadd', ['breadcrumbs' => $breadcrumbs]);
    }

    // store
    public function categorystore(Request $request)
    {
        $wordlist = Category::where('name', $request->name)->get();
        $wordCount = $wordlist->count();

        if($wordCount == 0)
        {
            $insertarr = array(
                'name' => $request->name,
                'status' => $request->status,
            );

            Category::create($insertarr);

            echo 1;
        }
        else
        {
            echo 2;
        }
    }

    // edit
    public function categoryedit($id)
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['link'=>"admin/category",'name'=>"Categories"], ['name'=>"Edit Category"]
        ];

        $category = Category::findOrFail($id);

        return view('/admin/category/categoryedit', ['breadcrumbs' => $breadcrumbs,'category' => $category]);
    }

    // update
    public function categoryupdate(Request $request)
    {
        $wordlist = Category::where('name', $request->name)->where('id','!=' ,$request->id)->get();
        $wordCount = $wordlist->count();

        if($wordCount == 0)
        {
            $category = Category::find($request->id);

            $updatearr = array(
                'name' => $request->name,
                'status' => $request->status,
            );

            $category->update($updatearr);

            echo 1;
        }
        else
        {
            echo 2;
        }
    }

    // destroy or delete
    public function categorydestroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => 'Record deleted successfully!',
        ]);
    }

    // show
    public function categoryview($id)
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['link'=>"admin/category",'name'=>"Categories"], ['name'=>"View Category"]
        ];

        $category = Category::findOrFail($id);

        return view('/admin/category/categoryview', ['breadcrumbs' => $breadcrumbs, 'category' => $category]);
    }

    // get category product
    public function getCategoryProduct(Request $request, $id)
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
        $totalRecords = Product::select('count(*) as allcount')->where('products.id_category', $id)->count();
        $totalRecordswithFilter = Product::select('count(*) as allcount')->where('products.name', 'like', '%' . $searchValue . '%')->where('products.id_category', $id)->count();

        // Fetch records
        $records = Product::orderBy('products.id', "desc")
            ->where('products.name', 'like', '%' . $searchValue . '%')
            ->select('products.*')
            ->where('products.id_category', $id)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = array();
        $counter = 0;
        foreach ($records as $record) {

            if($record['status'] == '1')
            {
                $status = '<span class="badge rounded-pill text-bg-success">Active</span>';
            }
            else
            {
                $status = '<span class="badge rounded-pill text-bg-danger">Inactive</span>';
            }

            $row = array();
            $row[] = ++$counter;

            $price = '<i class="fa-solid fa-indian-rupee-sign"></i>&nbsp;'.$record['price'];

            $row[] = $record['name'];
            $row[] = $price;

            $row[] = $status;

            $Action = '';

            if(Auth::user()->can('product-edit'))
            {

                $Action .= '<a href="' . route("productedit", [$record["id"]]) . '"><i class="fa-regular fa-pen-to-square"></i></a>&nbsp;&nbsp;&nbsp;';

            }

            if(Auth::user()->can('product-view'))
            {

                $Action .= '<a href="' . route("productview", [$record["id"]]) . '"><i class="fa-regular fa-eye"></i></a>&nbsp;&nbsp;&nbsp;';

            }

            if(Auth::user()->can('product-delete'))
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
}
