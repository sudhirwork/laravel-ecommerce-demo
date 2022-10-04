<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list|user-add|user-edit|user-delete|user-view', ['only' => ['index','getUser','useradd','userstore','useredit','userupdate','userdelete']]);
        $this->middleware('permission:user-list', ['only' => ['index','getUser']]);
        $this->middleware('permission:user-add', ['only' => ['useradd','userstore']]);
        $this->middleware('permission:user-edit', ['only' => ['useredit','userupdate']]);
        $this->middleware('permission:user-delete', ['only' => ['userdelete']]);
        $this->middleware('permission:user-view', ['only' => ['']]);
    }

    // home
    public function index()
    {
        $breadcrumbs = [
        ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['name'=>"Users"]
        ];

        return view('/admin/user/user', ['breadcrumbs' => $breadcrumbs]);
    }

    public function getUser(Request $request)
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

        $authid = Auth::user()->id;

        // Total records
        $totalRecords = User::select('count(*) as allcount')->where('deleted_at',NULL)->where('users.id', '!=' , $authid)->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->where('deleted_at',NULL)->where('users.id', '!=' , $authid)->count();

        // Fetch records
        $records = User::orderBy('users.id', "desc")
            ->where('users.name', 'like', '%' . $searchValue . '%')
            ->where('deleted_at',NULL)
            ->where('users.id', '!=' , $authid)
            ->select('users.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = array();
        $counter = 0;
        foreach ($records as $record)
        {
            if($record['status'] == '1')
            {
                $status = '<span class="badge badge-pill badge-light-success mr-1">Active</span>';
            }
            else
            {
                $status = '<span class="badge badge-pill badge-light-danger mr-1">Inactive</span>';
            }

            $adminuser = User::where('email', $record['email'])->first();
            $adminuserrole = $adminuser->roles->pluck('name','name')->first();

            if ($adminuserrole != '')
            {
                $adminrole = '<span class="badge badge-pill badge-light-primary">'.$adminuserrole.'</span>';
            }
            else
            {
                $adminrole = '<span class="badge badge-pill badge-danger">No Role</span>';
            }

            $row = array();
            $row[] = ++$counter;

            $row[] = $adminrole;

            $row[] = $record['name'];
            $row[] = $record['email'];

            $row[] = $status;

            $Action = '';

            if(Auth::user()->can('user-edit'))
            {
                $Action .= '<a href="' . route("useredit", [$record["id"]]) . '"><i class="fa-regular fa-pen-to-square"></i></a>&nbsp;&nbsp;&nbsp;';
            }

            if(Auth::user()->can('user-delete'))
            {
                if($adminuserrole != 'admin' && $record['role'] != 'admin')
                {
                    $Action .= '<a data-id="' . $record["id"] . '"  href="javascript:;" class="deleteRecord"><i class="fa-regular fa-trash-can"></i></a>&nbsp;&nbsp;&nbsp;';
                }
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

    public function useradd()
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['link'=>"admin/user",'name'=>"Users"], ['name'=>"Add User"]
        ];

        $roles = Role::pluck('name','name')->all();

        return view('/admin/user/useradd', ['breadcrumbs' => $breadcrumbs, 'roles' => $roles]);
    }

    public function userstore(Request $request)
    {
        $wordlist = User::where('email', $request->email)->get();

        $wordCount = $wordlist->count();

        if($wordCount == 0){

            $insertarr = array(
                'role' => $request->roles,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => $request->status,
            );

            $adminuser = User::create($insertarr);
            $adminuser->assignRole($request->roles);

            echo 1;
        }
        else
        {
            echo 2;
        }

    }

    public function useredit($id)
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['link'=>"admin/user",'name'=>"Users"], ['name'=>"Edit User"]
        ];

        $user = User::findOrFail($id);

        $roles = Role::pluck('name','name')->all();

        $adminuserrole = $user->roles->pluck('name','name')->first(); // all()

        return view('/admin/user/useredit', ['breadcrumbs' => $breadcrumbs,'user' => $user, 'roles' => $roles, 'adminuserrole' => $adminuserrole]);
    }

    public function userupdate(Request $request)
    {
        $wordlist = User::where('email', $request->email)->where('id','!=' ,$request->id)->get();

        $wordCount = $wordlist->count();

        if($wordCount == 0)
        {
            $user = User::find($request->id);

            if(!empty($request->password))
            {
                $password = Hash::make($request->password);
            }
            else
            {
                $password = $user->password;
            }

            $updatearr = array(
                'role' => $request->roles,
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'status' => $request->status,
            );

            $user->update($updatearr);

            DB::table('model_has_roles')->where('model_id',$request->id)->delete();

            $user->assignRole($request->roles);

            echo 1;
        }
        else
        {
            echo 2;
        }
    }

    public function userdelete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'success' => 'Record deleted successfully!',
        ]);
    }

}
