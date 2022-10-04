<nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">

            <a class="nav-link" href="{{route('dashboard')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-gauge fa-lg"></i></div>
                Dashboard
            </a>

            @can('category-list')

                <a class="nav-link" href="{{url('admin/category')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-border-all fa-lg"></i></div>
                    Categories
                </a>

            @endcan

            @can('product-list')

                <a class="nav-link" href="{{url('admin/product')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-store fa-lg"></i></div>
                    Products
                </a>

            @endcan

            @can('cart-list')

                <a class="nav-link" href="{{url('admin/cart')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping fa-lg"></i></div>
                    Carts
                </a>

            @endcan

            @can('customer-list')

                <a class="nav-link" href="{{url('admin/customer')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-users fa-lg"></i></div>
                    Customers
                </a>

            @endcan

            @can('user-list')

                <a class="nav-link" href="{{url('admin/user')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user-group fa-lg"></i></div>
                    Users
                </a>

            @endcan

            @can('role-list')

                <a class="nav-link" href="{{url('admin/roles/role')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-shield-halved fa-lg"></i></div>
                    Roles & Permissions
                </a>

            @endcan

            <a class="nav-link" href="{{url('/admin/logout')}}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-power-off fa-lg"></i></div>
                Logout
            </a>

            {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-table-columns fa-lg"></i></div>
                Layouts
                <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-circle-chevron-down fa-sm"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">

                    <a class="nav-link" href="layout-static.html">
                        <div class="sb-nav-link-icon"><i class="fa-regular fa-circle fa-xs"></i></div>
                        Static Navigation
                    </a>

                    <a class="nav-link" href="layout-sidenav-light.html">
                        <div class="sb-nav-link-icon"><i class="fa-regular fa-circle fa-xs"></i></div>
                        Light Sidenav
                    </a>

                </nav>
            </div> --}}

        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="row">
            <div class="col-8">
                <strong>{{Auth::user()->name}}</strong>
                <div class="small">Administrator</div>
            </div>

            @if (isset(Auth::user()->profile_image) && !empty(Auth::user()->profile_image))

                @if (!file_exists(public_path().'/adminprofile/'.Auth::user()->profile_image))

                    <div class="col-4">
                        <div class="rounded-3 p-0 m-0 text-center position-relative" style="height: 45px; width: 45px;">

                        <div class="text-white rounded-3 m-0" style="height: 45px; width: 45px; padding-top: 10px; background-color: #B8B3F6;">
                            <i class="fa-regular fa-face-smile fa-2xl"></i>
                        </div>

                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">Online</span>
                        </span>
                        </div>
                    </div>

                @else

                    <div class="col-4">
                        <div class="rounded-3 p-0 m-0 text-center position-relative" style="height: 45px; width: 45px;">
                        <img class="rounded-3 img-fluid" src="{{asset('adminprofile/'.Auth::user()->profile_image)}}" alt="avatar" style="height: 45px; width: 45px;">
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">Online</span>
                        </span>
                        </div>
                    </div>

                @endif

            @elseif (isset(Auth::user()->name) && !empty(Auth::user()->name))

                <div class="col-4">
                    <div class="rounded-3 p-0 m-0 text-center position-relative" style="height: 45px; width: 45px;">

                    <div class="text-white rounded-3 m-0" style="height: 45px; width: 45px; padding-top: 10px; background-color: #B8B3F6;">
                        <i class="fa-regular fa-<?php echo strtolower(substr(Auth::user()->name,0,1)) ?> fa-2xl"></i>
                    </div>

                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                        <span class="visually-hidden">Online</span>
                    </span>
                    </div>
                </div>

            @else

                <div class="col-4">
                    <div class="rounded-3 p-0 m-0 text-center position-relative" style="height: 45px; width: 45px;">

                    <div class="text-white rounded-3 m-0" style="height: 45px; width: 45px; padding-top: 10px; background-color: #B8B3F6;">
                        <i class="fa-regular fa-face-smile fa-2xl"></i>
                    </div>

                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                        <span class="visually-hidden">Online</span>
                    </span>
                    </div>
                </div>

            @endif

        </div>

    </div>
</nav>
