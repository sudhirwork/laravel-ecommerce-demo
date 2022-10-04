<?php

use Illuminate\Support\Facades\Route;

// admin route Controller
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\AdminProfileController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\CartController;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;


// store route Controller
use App\Http\Controllers\store\StoreHomeController;
use App\Http\Controllers\store\StoreCustomerController;
use App\Http\Controllers\store\StoreProductController;
use App\Http\Controllers\store\StoreCartController;
use App\Http\Controllers\store\StoreOrderController;
use App\Http\Controllers\store\StoreAuthenticatedController;


/*
|--------------------------------------------------------------------------
| Admin Routes
--------------------------------------------------------------------------
|
*/

    // Admin Auth Routes
    Route::redirect('/admin', '/admin/login', 301);
    Route::prefix('admin')->group(function () {

        // Route::redirect('/', '/admin/login', 301);
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'adminauthenticate'])->name('authenticate');

        // Forgot Password
        Route::get('/forgot', [LoginController::class, 'forgot'])->name('forgot');
        Route::post('/forgotpassword', [LoginController::class, 'forgotpassword'])->name('forgotpassword');
    });

Route::prefix('admin')->middleware(['auth'])->group(function () {

    // Admin Dashboard Routes
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        // Profile Data
        Route::get('adminprofileedit/{id}', [AdminProfileController::class, 'adminprofileedit'])->name('adminprofileedit');
        Route::post('adminprofileupdate', [AdminProfileController::class, 'adminprofileupdate'])->name('adminprofileupdate');


    // Get Data
    Route::get('roles/role', [RoleController::class, 'index'])->name('role');
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::get('category', [CategoryController::class, 'index'])->name('category');
    Route::get('product', [ProductController::class, 'index'])->name('product');
    Route::get('customer', [CustomerController::class, 'index'])->name('customer');
    Route::get('cart', [CartController::class, 'index'])->name('cart');


    // Add Data
    Route::get('roles/role/roleadd', [RoleController::class, 'roleadd'])->name('roleadd');
    Route::get('user/useradd', [UserController::class, 'useradd'])->name('useradd');
    Route::get('category/categorycreate', [CategoryController::class, 'categorycreate'])->name('categorycreate');
    Route::get('product/productcreate', [ProductController::class, 'productcreate'])->name('productcreate');


    // Edit Data
    Route::get('roles/role/roleedit/{id}', [RoleController::class, 'roleedit'])->name('roleedit');
    Route::get('user/useredit/{id}', [UserController::class, 'useredit'])->name('useredit');
    Route::get('category/categoryedit/{id}', [CategoryController::class, 'categoryedit'])->name('categoryedit');
    Route::get('product/productedit/{id}', [ProductController::class, 'productedit'])->name('productedit');


    // Store Data
    Route::post('roles/rolestore', [RoleController::class, 'rolestore'])->name('rolestore');
    Route::post('userstore', [UserController::class, 'userstore'])->name('userstore');
    Route::post('categorystore', [CategoryController::class, 'categorystore'])->name('categorystore');
    Route::post('productstore', [ProductController::class, 'productstore'])->name('productstore');


    // Update Data
    Route::post('roles/roleupdate', [RoleController::class, 'roleupdate'])->name('roleupdate');
    Route::post('userupdate', [UserController::class, 'userupdate'])->name('userupdate');
    Route::post('categoryupdate', [CategoryController::class, 'categoryupdate'])->name('categoryupdate');
    Route::post('productupdate', [ProductController::class, 'productupdate'])->name('productupdate');


    // Delete Data
    Route::delete('roles/role/{id}', [RoleController::class, 'roledestroy'])->name('roledestroy');
    Route::delete('user/{id}', [UserController::class, 'userdelete'])->name('userdelete');
    Route::delete('category/{id}', [CategoryController::class, 'categorydestroy'])->name('categorydestroy');
    Route::delete('product/{id}', [ProductController::class, 'productdestroy'])->name('productdestroy');
    Route::delete('product/productedit/image/{id}', [ProductController::class, 'imagedestroy'])->name('imagedestroy');
    Route::delete('customer/{id}', [CustomerController::class, 'customerdestroy'])->name('customerdestroy');


    // View Data
    Route::get('roles/role/roleview/{id}', [RoleController::class, 'roleview'])->name('roleview');
    Route::get('category/categoryview/{id}', [CategoryController::class, 'categoryview'])->name('categoryview');
    Route::get('product/productview/{id}', [ProductController::class, 'productview'])->name('productview');
    Route::get('customer/customerview/{id}', [CustomerController::class, 'customerview'])->name('customerview');


    // Get Table Data
    Route::post('roles/getRole/', [RoleController::class, 'getRole'])->name('admin.getRole');
    Route::post('/admin/getUser/', [UserController::class, 'getUser'])->name('admin.getUser');
    Route::post('/admin/getCategory/', [CategoryController::class, 'getCategory'])->name('admin.getCategory');
    Route::post('/admin/getCategoryProduct/{id}', [CategoryController::class, 'getCategoryProduct'])->name('admin.getCategoryProduct');
    Route::post('/admin/getProduct/', [ProductController::class, 'getProduct'])->name('admin.getProduct');
    Route::post('/admin/getCustomer/', [CustomerController::class, 'getCustomer'])->name('admin.getCustomer');
    Route::post('/admin/getCart/', [CartController::class, 'getCart'])->name('admin.getCart');


        // Get Select2 Data
        Route::post('getallcategory/', [ProductController::class, 'getallcategory'])->name('getallcategory');

    // Admin Logout
    Route::get('logout', function () {
        Auth::logout();
        return redirect('admin/login');
    });

});


/*
|--------------------------------------------------------------------------
| Store Routes
--------------------------------------------------------------------------
|
*/

// Store Home Routes
Route::redirect('/', '/home', 301);
Route::get('home', [StoreHomeController::class, 'index'])->name('home');

// for store customer Auth
Route::controller(StoreCustomerController::class)->group(function () {

    // customer register
    Route::get('/home/register', 'registerform')->name('registerform');
    Route::post('/home/register/registercustomer', 'registercustomer')->name('registercustomer');

        // Get Select2 Data
        Route::post('getcountry/', 'getcountry')->name('getcountry');
        Route::post('getstate/', 'getstate')->name('getstate');
        Route::post('getcity/', 'getcity')->name('getcity');


    // customer login
    Route::get('/home/login', 'loginform')->name('loginform');
    Route::post('/home/login/logincustomer', 'logincustomer')->name('logincustomer');

    // check guest login or register for add to cart
    Route::get('/home/guest/register', 'checkregisterform')->name('checkregisterform');
    Route::get('/home/guest/login', 'checkloginform')->name('checkloginform');

    // customer forgot & reset password
    Route::get('/home/forgot', 'forgotcustomerform')->name('forgotcustomerform');
    Route::post('/home/forgot/forgotcustomer', 'forgotcustomer')->name('forgotcustomer');

    Route::get('reset-password/{token}', 'customerresetpasswordform')->name('customerresetpasswordform');
    Route::post('reset-password', 'customerresetpassword')->name('customerresetpassword');
    Route::get('reset-password-fail', 'customerresetfail')->name('customerresetfail');

});


// for store product
Route::controller(StoreProductController::class)->group(function () {

    // product route
    Route::get('product/{value}', 'index')->name('product');
    Route::get('product/productdetails/{id}', 'productdetails')->name('productdetails');

    // ajax post
    Route::post('addtocart/', 'addtocart')->name('addtocart');

    // get product data
    Route::post('product/getProduct/{value}', 'getProduct')->name('getProduct');

});


// customer if authenticated
Route::middleware(['auth:customer'])->group(function () {

    // for store cart
    Route::controller(StoreCartController::class)->group(function () {

        // cart route
        Route::get('cart/{id}', 'index')->name('cart');

        // ajax post
        Route::post('qtyUpdate/', 'qtyUpdate')->name('qtyUpdate');

        // cart destroy route
        Route::delete('cartitemdestroy/{id}', 'cartitemdestroy')->name('cartitemdestroy');
        Route::delete('wholecartitemdestroy/{id}', 'wholecartitemdestroy')->name('wholecartitemdestroy');

    });


    // for store order
    Route::controller(StoreOrderController::class)->group(function () {

        // order route
        Route::get('checkout', 'index')->name('checkout');

            // Get Select2 Data
            Route::post('getallcountry/', 'getallcountry')->name('getallcountry');
            Route::post('getallstate/', 'getallstate')->name('getallstate');
            Route::post('getallcity/', 'getallcity')->name('getallcity');


        // ajax post
        Route::post('placeorder/', 'placeorder')->name('placeorder');

    });


    Route::controller(StoreAuthenticatedController::class)->group(function () {

        // customer page view route
        Route::get('profile', 'customerprofile')->name('customerprofile');
        Route::get('profileedit', 'customerprofileedit')->name('customerprofileedit');
        Route::get('changepassword', 'changepassword')->name('changepassword');
        Route::get('myorder', 'myorder')->name('myorder');


        // ajax post
        Route::post('changeingpassword/', 'changeingpassword')->name('changeingpassword');
        Route::post('profileupdate/', 'customerprofileupdate')->name('customerprofileupdate');
    });

    // customer logout
    Route::get('logout', function () {
        Auth::guard('customer')->logout();
        return redirect('home');
    });

});
