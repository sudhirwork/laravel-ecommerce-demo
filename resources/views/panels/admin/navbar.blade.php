<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand text-center text-warning pt-2" style="padding: 1px;" href="{{route('dashboard')}}"><h4><i class="fa-solid fa-shop"></i> Store</h4></a> <!-- rounded border bg-secondary -->
    <!-- Sidebar Toggle-->
    <button style="margin-left: 10px;" class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fa-solid fa-bars"></i></button>
    <!-- Navbar Search-->
    {{-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button" style="color: #ffffff;"><i class="fas fa-search"></i></button>
        </div>
    </form> --}}
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0"> <!-- ms-auto ms-md-0 me-3 me-lg-4-->
        <li class="nav-item dropdown">

            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user-shield fa-xl"></i></a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                <li><a class="dropdown-item" href="{{route('adminprofileedit', [Auth::user()->id])}}"><i class="fa-solid fa-user-pen"></i> Edit</a></li>

                <li><hr class="dropdown-divider" /></li>

                <li><a class="dropdown-item" href="/admin/logout"><i class="fa-solid fa-power-off"></i> Logout</a></li>

            </ul>

        </li>
    </ul>
</nav>
