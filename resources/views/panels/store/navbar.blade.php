@php

    $categories = App\Models\Category::where('status', '1')->get();

@endphp

<header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand text-center text-warning pt-2 ps-4 pe-4" style="padding: 1px;" href="{{route('home')}}"><h4><i class="fa-solid fa-shop"></i> Store</h4></a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarCollapse">

        <ul class="navbar-nav me-auto mb-2 mb-md-0 ps-4">

          <li class="nav-item">
            <a class="nav-link {{ (request()->is('home')) ? 'active' : '' }}" aria-current="page" href="{{route('home')}}">Home</a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ (request()->is('product/list')) ? 'active' : '' }}" href="{{route('product', ['value' => 'list'])}}">Products</a>
          </li>

          <li class="nav-item dropdown">

            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>

            <ul class="dropdown-menu">

                @foreach ($categories as $category)

                    <li><a class="dropdown-item {{ (request()->is('product/'.$category->id.'')) ? 'active' : '' }}" href="{{route('product', ['value' => $category->id])}}">{{$category->name}}</a></li>

                @endforeach

            </ul>

          </li>

        </ul>

        {{-- <form class="ps-4 pe-4" style="width: 400px;" role="search">
            <input class="form-control" type="search" placeholder="🔍︎ Search Products..." aria-label="Search">
        </form> --}}

        @if (Auth::guard('customer')->check())

            <ul class="navbar-nav ps-4 pe-2">
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">

                        @if (isset(Auth::guard('customer')->user()->profile_image) && !empty(Auth::guard('customer')->user()->profile_image))

                            @if (!file_exists(public_path().'/customerprofile/'.Auth::guard('customer')->user()->profile_image))

                                <button class="text-white text-center rounded-circle" style="height: 45px; width: 45px; background-color: #B8B3F6; border: none;">
                                    <i class="fa-regular fa-face-smile fa-2xl"></i>
                                </button>&nbsp; Account

                            @else

                                <img src="{{asset('customerprofile/'.Auth::guard('customer')->user()->profile_image)}}" width="45" height="45" class="img-fluid rounded-circle" alt="image">&nbsp; Account

                            @endif

                        @elseif (isset(Auth::guard('customer')->user()->first_name) && !empty(Auth::guard('customer')->user()->first_name))

                            <button class="text-white text-center rounded-circle" style="height: 45px; width: 45px; background-color: #B8B3F6; border: none;">
                                <i class="fa-regular fa-<?php echo strtolower(substr(Auth::guard('customer')->user()->first_name,0,1)) ?> fa-2xl"></i>
                            </button>&nbsp; Account

                        @else

                            <button class="text-white text-center rounded-circle" style="height: 45px; width: 45px; background-color: #B8B3F6; border: none;">
                                <i class="fa-regular fa-face-smile fa-2xl"></i>
                            </button>&nbsp; Account

                        @endif

                    </a>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ (request()->is('profile')) ? 'active' : '' }}" href="{{route('customerprofile')}}"><i class="fa-solid fa-user"></i>&nbsp; Profile</a></li>

                        <li><a class="dropdown-item {{ (request()->is('changepassword')) ? 'active' : '' }}" href="{{route('changepassword')}}"><i class="fa-solid fa-key"></i>&nbsp; Change Password</a></li>

                        <li><a class="dropdown-item {{ (request()->is('myorder')) ? 'active' : '' }}" href="{{route('myorder')}}"><i class="fa-solid fa-truck-fast"></i>&nbsp; Orders</a></li>

                        <li><a class="dropdown-item {{ (request()->is('logout')) ? 'active' : '' }}" href="/logout"><i class="fa-solid fa-power-off"></i>&nbsp; Logout</a></li>
                    </ul>

                </li>
            </ul>

        @else

            <ul class="navbar-nav ps-4 pe-2">

                <li class="nav-item"><a href="{{route('loginform')}}" class="nav-link"><button type="button" class="btn btn-outline-warning"><i class="fa-solid fa-right-to-bracket"></i>&nbsp; Login</button></a></li>

                <li class="nav-item"><a href="{{route('registerform')}}" class="nav-link"><button type="button" class="btn btn-warning"><i class="fa-solid fa-user-plus"></i>&nbsp; Register</button></a></li>

            </ul>

        @endif

        <ul class="navbar-nav ps-4 pe-4">

            @if (Auth::guard('customer')->check())

                @php

                    $cart = App\Models\Cart::where('id_customer', Auth::guard('customer')->user()->id)->get();

                    $cartcount = $cart->count();

                @endphp

                @if ($cartcount == 0)

                    <li class="nav-item">

                        <a href="#" onclick="checkcart()" class="nav-link" id="remove-click">
                            <button type="button" class="btn btn-warning position-relative">
                                <i class="fa-solid fa-cart-shopping"></i>

                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="main-cart-count">{{$cartcount}}</span>
                            </button>
                        </a>

                    </li>

                @else

                    <li class="nav-item">

                        <a href="{{route('cart', ['id' => Auth::guard('customer')->user()->id])}}" class="nav-link" id="remove-click" onclick=null>
                            <button type="button" class="btn btn-warning position-relative">
                                <i class="fa-solid fa-cart-shopping"></i>

                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="main-cart-count">{{$cartcount}}</span>
                            </button>
                        </a>

                    </li>

                @endif

            @else

                <li class="nav-item">

                    <a href="#" onclick="checkauth()" class="nav-link">
                        <button type="button" class="btn btn-warning">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </button>
                    </a>

                </li>

            @endif

        </ul>

      </div>

    </div>
  </nav>
</header>
