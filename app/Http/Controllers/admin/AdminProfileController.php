<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class AdminProfileController extends Controller
{
  // profile edit
  public function adminprofileedit($id)
  {
    $breadcrumbs = [
        ['link'=>"admin/dashboard",'name'=>"Dashboard"], ['name'=>"Edit Admin Profile"]
    ];
        $admin = User::findOrFail($id);

        return view('/admin/profile/profileedit', ['breadcrumbs' => $breadcrumbs,'admin' => $admin]);
  } 

  public function adminprofileupdate(Request $request)
  {
    $wordlist = User::where('email', $request->email)->where('id','!=' ,$request->id)->get();
    $wordCount = $wordlist->count();

    if($wordCount == 0)
    {
      $admins = User::find($request->id);

      if(!empty($request->password))
      {
          $password = Hash::make($request->password);
      } 
      else 
      {
          $password = $admins->password;
      }

      $admin = User::findOrFail($request->id);
      if ($files = $request->file('profile_image')) 
      {
        if(!File::isDirectory(public_path('adminprofile')))
        {
          File::makeDirectory(public_path('adminprofile'));

          // upload new file
          $filename = date('YmdHis')."-".str_ireplace(' ', '', $files->getClientOriginalName());
          $files->move('adminprofile', $filename);

          //for update in table
          $image = $filename;
        }
        else
        {  
          $path = public_path().'/adminprofile/';

          // code for remove old file
          if($admins->profile_image != ''  && $admins->profile_image != null && !empty($admins->profile_image))
          {
            $file_old = $path.$admins->profile_image;

            if(File::exists($file_old))
            {
              unlink($file_old);
            }
          }

          // upload new file
          $filename = date('YmdHis')."-".str_ireplace(' ', '', $files->getClientOriginalName());
          $files->move('adminprofile', $filename);

          //for update in table
          $image = $filename;
        }
      } 
      else 
      {
        $image = $admins->profile_image;
      }

      $updatearr = array(
          'name' => $request->name,
          'email' => $request->email,
          'password' => $password,
          'profile_image' => $image,
      );

      $admin->update($updatearr);

      echo 1;
    } 
    else 
    {
      echo 2;
    }
  }
 
}
