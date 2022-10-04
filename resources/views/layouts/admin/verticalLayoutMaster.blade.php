    <body class="sb-nav-fixed" style="background-color: #F8F8F8">

        <!-- BEGIN: Content-->

        {{-- Include Navbar --}}
        @include('panels.admin.navbar')

        <div id="layoutSidenav">

            <div id="layoutSidenav_nav">

                {{-- Include Sidebar --}}
                @include('panels.admin.sidebar')

            </div>

            <div id="layoutSidenav_content">

                <main>
                    <div class="container-fluid px-4">

                        {{-- Include Page Content --}}
                        @yield('content')

                    </div>
                </main>

                {{-- include footer --}}
                @include('panels/admin/footer')

            </div>

        </div>

        <!-- End: Content-->

        {{-- include default scripts --}}
        @include('panels/admin/scripts')

        <script>

        </script>

    </body>
</html>
