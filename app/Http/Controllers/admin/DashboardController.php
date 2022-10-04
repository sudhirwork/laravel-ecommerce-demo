<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:dashboard-appuser-chart|dashboard-appuser-list|dashboard-appuser-counter', ['only' => ['getDashboardAppuser']]);
    //     $this->middleware('permission:dashboard-appuser-list', ['only' => ['getDashboardAppuser']]);
    //     $this->middleware('permission:dashboard-appuser-chart', ['only' => ['']]);
    //     $this->middleware('permission:dashboard-appuser-counter', ['only' => ['']]);
    // }

  // home
  public function dashboard()
  {
    // $breadcrumbs = [
    //     ['link'=>"dashboard",'name'=>"Dashboard"], ['name'=>"Index"]
    // ];

    return view('/admin/dashboard');

  }

}
