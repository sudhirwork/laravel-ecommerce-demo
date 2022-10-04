<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list|role-add|role-edit|role-delete|role-view', ['only' => ['index','getRole','roleadd','rolestore','roleedit','roleupdate','roledestroy','roleview']]);
        $this->middleware('permission:role-list', ['only' => ['index','getRole']]);
        $this->middleware('permission:role-add', ['only' => ['roleadd','rolestore']]);
        $this->middleware('permission:role-edit', ['only' => ['roleedit','roleupdate']]);
        $this->middleware('permission:role-delete', ['only' => ['roledestroy']]);
        $this->middleware('permission:role-view', ['only' => ['roleview']]);
    }

    // home
    public function index()
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['name'=>"Roles & Permissions"]
        ];

        return view('/admin/roles/role', ['breadcrumbs' => $breadcrumbs]);
    }

    public function getRole(Request $request)
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
        $totalRecords = Role::select('count(*) as allcount')
        // ->where('roles.id', '!=', 3)
        ->count();
        $totalRecordswithFilter = Role::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')
        // ->where('roles.id', '!=', 3)
        ->count();

        // Fetch records
        $records = Role::orderBy('roles.id', "desc")
            ->where('roles.name', 'like', '%' . $searchValue . '%')
            ->select('roles.*')
            // ->where('roles.id', '!=', 1)
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data = array();
        $counter = 0;
        foreach ($records as $record)
        {
            $row = array();
            $row[] = ++$counter;
            $row[] = $record['name'];

            $Action = '';

            if(Auth::user()->can('role-edit'))
            {
                $Action .= '<a href="' . route("roleedit", [$record["id"]]) . '"><i class="fa-regular fa-pen-to-square"></i></a>&nbsp;&nbsp;&nbsp;';
            }

            if(Auth::user()->can('role-view'))
            {
                $Action .= '<a href="' . route("roleview", [$record["id"]]) . '"><i class="fa-regular fa-eye"></i></a>&nbsp;&nbsp;&nbsp;';
            }

            if(Auth::user()->can('role-delete'))
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

    public function roleadd()
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['link'=>"admin/roles/role",'name'=>"Roles & Permissions"], ['name'=>"Add Role & Permissions"]
        ];

        $permission = Permission::get();

        return view('/admin/roles/roleadd', ['permission' => $permission, 'breadcrumbs' => $breadcrumbs]);
    }

    public function rolestore(Request $request)
    {
        $wordlist = Role::where('name', $request->name)->get();
        $wordCount = $wordlist->count();

        if($wordCount == 0)
        {
            $insertarr = array(
                'name' => $request->name,
            );

            $role = Role::create($insertarr);
            $role->syncPermissions($request->permission);

            echo 1;
        }
        else
        {
            echo 2;
        }
    }

    public function roleedit($id)
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['link'=>"admin/roles/role",'name'=>"Roles & Permissions"], ['name'=>"Edit Role & Permissions"]
        ];

        $role = Role::findOrFail($id);

        $permission = Permission::get();

        $rolePermissions = DB::table("role_has_permissions")
        ->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();

        return view('/admin/roles/roleedit', ['role' => $role, 'permission' => $permission, 'rolePermissions' => $rolePermissions, 'breadcrumbs' => $breadcrumbs]);
    }

    public function roleupdate(Request $request)
    {
        $wordlist = Role::where('name', $request->name)->where('id','!=' ,$request->id)->get();
        $wordCount = $wordlist->count();

        if($wordCount == 0)
        {
            $role = Role::find($request->id);
            $role->name = $request->name;
            $role->save();

            $role->syncPermissions($request->permission);

            $userids = DB::table('model_has_roles')->where('role_id',$request->id)->get();

            foreach ($userids as $userid)
            {
                $user = User::findOrFail($userid->model_id);

                $updatearr = array(
                    'role' => $request->name,
                );

                $user->update($updatearr);
            }

            echo 1;
        }
        else
        {
            echo 2;
        }
    }

    public function roledestroy($id)
    {
        // DB::table("roles")->where('id',$id)->delete();

        $role = Role::findOrFail($id);

        $userids = DB::table('model_has_roles')->where('role_id',$role->id)->get();

        foreach ($userids as $userid)
        {
            $user = User::findOrFail($userid->model_id);

            $updatearr = array(
                'role' => '',
                'status' => '0',
            );

            $user->update($updatearr);
        }

        $role->delete();

        return response()->json([
            'success' => 'Role has been deleted and All admin-users for this role are inactived successfully!',
        ]);
    }

    public function roleview($id)
    {
        $breadcrumbs = [
            ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['link'=>"admin/roles/role",'name'=>"Roles & Permissions"], ['name'=>"View Role & Permissions"]
        ];

        $role = Role::findOrFail($id);

        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where("role_has_permissions.role_id",$id)
        ->get();

        return view('/admin/roles/roleview', ['role' => $role, 'rolePermissions' => $rolePermissions, 'breadcrumbs' => $breadcrumbs]);
    }
}
