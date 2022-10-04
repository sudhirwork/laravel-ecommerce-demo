<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Productimage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-list|product-add|product-edit|product-delete|product-view', ['only' => ['index','getProduct','productcreate','productstore','productedit','productupdate','productdestroy','productview']]);
        $this->middleware('permission:product-list', ['only' => ['index','getProduct']]);
        $this->middleware('permission:product-add', ['only' => ['productcreate','productstore']]);
        $this->middleware('permission:product-edit', ['only' => ['productedit','productupdate']]);
        $this->middleware('permission:product-delete', ['only' => ['productdestroy']]);
        $this->middleware('permission:product-view', ['only' => ['productview']]);
    }

    // index
    public function index()
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['name'=>"Products"]
          ];

          return view('/admin/product/product', ['breadcrumbs' => $breadcrumbs]);
    }

    // get
    public function getProduct(Request $request)
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
        $totalRecords = Product::join('categories', 'products.id_category', '=', 'categories.id')->select('count(*) as allcount')->count();
        $totalRecordswithFilter = Product::join('categories', 'products.id_category', '=', 'categories.id')->select('count(*) as allcount')->where('products.name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Product::join('categories', 'products.id_category', '=', 'categories.id')
            ->orderBy('products.id', "desc")
            ->where('products.name', 'like', '%' . $searchValue . '%')
            ->select('products.name as productname','products.*', 'categories.name')
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

            $productthumbnail = '<img class="rounded-3 img-fluid" style="height:50px; width:50px;" src="'.url('/productthumbnail/'.$record['thumbnail']).'" alt="thumbnail">';

            $categoryname = '<span class="badge rounded-pill text-bg-primary">'.$record['name'].'</span>';

            $price = '<i class="fa-solid fa-indian-rupee-sign"></i>&nbsp;'.$record['price'];

            $row[] = $productthumbnail;
            $row[] = $categoryname;
            $row[] = $record['productname'];
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

    // create
    public function productcreate()
    {
        $breadcrumbs = [
          ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['link'=>"admin/product",'name'=>"Products"], ['name'=>"Add Product"]
        ];

        return view('/admin/product/productadd', ['breadcrumbs' => $breadcrumbs]);
    }

    // store
    public function productstore(Request $request)
    {
        $wordlist = Product::where('code', $request->title)->get();
        $wordCount = $wordlist->count();

        if($wordCount == 0)
        {
            if ($files = $request->file('thumbnail'))
            {
                if(!File::isDirectory(public_path('productthumbnail')))
                {
                    File::makeDirectory(public_path('productthumbnail'));

                    $name = date('YmdHis')."-".str_ireplace(' ', '', $files->getClientOriginalName());
                    $files->move('productthumbnail', $name);
                    $thumbnail = $name;
                }
                else
                {
                    $name = date('YmdHis')."-".str_ireplace(' ', '', $files->getClientOriginalName());
                    $files->move('productthumbnail', $name);
                    $thumbnail = $name;
                }
            }
            else
            {
                $thumbnail = '';
            }

            $insertarr = array(
                'id_category' => $request->catid,
                'thumbnail' => $thumbnail,
                'brand' => $request->brand,
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock_quantity' => $request->qty,
                'status' => $request->status,
            );

            $product = Product::create($insertarr);

            if(!File::isDirectory(public_path('productimages')))
            {
                File::makeDirectory(public_path('productimages'));
            }

            $images = array();

            if ($files = $request->file('image'))
            {
                foreach ($files as $file)
                {
                    $name = date('YmdHis')."-".str_ireplace(' ', '', $file->getClientOriginalName());
                    $file->move('productimages', $name);
                    $images[] = $name;
                }
            }

            foreach ($images as $key => $value)
            {
                $insertproductimagearr = array(
                    'id_project' => $product->id,
                    'image' => $value,
                );

                Productimage::create($insertproductimagearr);
            }

            echo 1;
        }
        else
        {
            echo 2;
        }
    }

    // edit
    public function productedit($id)
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['link'=>"admin/product",'name'=>"Products"], ['name'=>"Edit Product"]
        ];

        $product = Product::findOrFail($id);

        $productimages = Productimage::where('id_project', $product->id)->get();

        $category = Category::findOrFail($product->id_category);

        return view('/admin/product/productedit', ['breadcrumbs' => $breadcrumbs,'product' => $product,'productimages' => $productimages,'category' => $category]);
    }

    // update
    public function productupdate(Request $request)
    {
        $wordlist = Product::where('code', $request->title)->where('id','!=' ,$request->id)->get();
        $wordCount = $wordlist->count();

        if ($wordCount == 0)
        {
            $product = Product::find($request->id);

            if ($files = $request->file('thumbnail'))
            {
                if(!File::isDirectory(public_path('productthumbnail')))
                {
                    File::makeDirectory(public_path('productthumbnail'));

                    // upload new file
                    $filename = date('YmdHis')."-".str_ireplace(' ', '', $files->getClientOriginalName());
                    $files->move('productthumbnail', $filename);

                    //for update in table
                    $thumbnail = $filename;
                }
                else
                {
                    $path = public_path().'/productthumbnail/';

                    // code for remove old file
                    if($product->thumbnail != ''  && $product->thumbnail != null && !empty($product->thumbnail))
                    {
                        $file_old = $path.$product->thumbnail;

                        if(File::exists($file_old))
                        {
                            unlink($file_old);
                        }
                    }

                    // upload new file
                    $filename = date('YmdHis')."-".str_ireplace(' ', '', $files->getClientOriginalName());
                    $files->move('productthumbnail', $filename);

                    //for update in table
                    $thumbnail = $filename;
                }
            }
            else
            {
                $thumbnail = $product->thumbnail;
            }

            $updatearr = array(
                'id_category' => $request->catid,
                'thumbnail' => $thumbnail,
                'brand' => $request->brand,
                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock_quantity' => $request->qty,
                'status' => $request->status,
            );

            $product->update($updatearr);

            if(!File::isDirectory(public_path('productimages')))
            {
                File::makeDirectory(public_path('productimages'));
            }

            $images = array();

            if ($files = $request->file('image'))
            {
                foreach ($files as $file)
                {
                    $name = date('YmdHis')."-".str_ireplace(' ', '', $file->getClientOriginalName());
                    $file->move('productimages', $name);
                    $images[] = $name;
                }

                foreach ($images as $key => $value)
                {
                    $insertproductimagearr = array(
                        'id_project' => $product->id,
                        'image' => $value,
                    );

                    Productimage::create($insertproductimagearr);
                }
            }

            echo 1;
        }
        else
        {
            echo 2;
        }
    }

    // product destroy or delete
    public function productdestroy($id)
    {
        $productimages = Productimage::where('id_project', $id)->get();

        if(!empty($productimages->toArray()))
        {
            if(File::isDirectory(public_path('productimage')))
            {
                foreach ($productimages as $productimage)
                {
                    $path = public_path().'/productimage/';

                    //code for remove old file
                    if($productimage->image != ''  && $productimage->image != null && !empty($productimage->image))
                    {
                        $file_old = $path.$productimage->image;

                        if(File::exists($file_old))
                        {
                            unlink($file_old);
                        }
                    }
                }
            }
        }

        $products = Product::findOrFail($id);

        if(File::isDirectory(public_path('productthumbnail')))
        {
            $thumbnail = public_path().'/productthumbnail/';

            //code for remove old file
            if($products->thumbnail != ''  && $products->thumbnail != null && !empty($products->thumbnail))
            {
                $file_old1 = $thumbnail.$products->thumbnail;

                if(File::exists($file_old1))
                {
                    unlink($file_old1);
                }
            }
        }

        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'success' => 'Record deleted successfully!',
        ]);
    }

    // product image destroy or delete
    public function imagedestroy($id)
    {
        $productimage = Productimage::findOrFail($id);
        $productimage->delete();

        if(File::isDirectory(public_path('productimage')))
        {
            $path = public_path().'/productimage/';

            //code for remove old file
            if($productimage->image != ''  && $productimage->image != null && !empty($productimage->image))
            {
                $file_old = $path.$productimage->image;

                if(File::exists($file_old))
                {
                    unlink($file_old);
                }
            }
        }

        return response()->json([
            'success' => 'Record deleted successfully!',
        ]);
    }

    // show
    public function productview($id)
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['link'=>"admin/product",'name'=>"Products"], ['name'=>"View Product"]
        ];

        $product = Product::findOrFail($id);

        $productimages = Productimage::where('id_project', $product->id)->get();

        $category = Category::findOrFail($product->id_category);

        return view('/admin/product/productview', ['breadcrumbs' => $breadcrumbs,'product' => $product,'productimages' => $productimages,'category' => $category]);
    }

    public function getallcategory(Request $request)
    {
        if($request->searchCat != '')
        {
            $categories = Category::select('id','name as text')->where('status', '1')->where('categories.name', 'like', '%' . $request->searchCat . '%')->orderBy('name', 'asc')->simplePaginate(10);
        }
        else
        {
            $categories = Category::select('id','name as text')->where('status', '1')->orderBy('name', 'asc')->simplePaginate(10);
        }

        $morePages=true;

        $pagination_obj = json_encode($categories);

        if (empty($categories->nextPageUrl()))
        {
            $morePages=false;
        }

        $results = array(
            "results" => $categories->items(),
            "pagination" => array(
            "more" => $morePages
            )
        );

        return Response::json($results);
    }
}
