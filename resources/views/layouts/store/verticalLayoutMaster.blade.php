    <body class="overflow-auto" style="padding-top: 40px; padding-bottom: 200px;">

        <!-- BEGIN: Content-->

        {{-- Include Navbar --}}
        @include('panels.store.navbar')

        <main>
            <br><br>

            <div class="album bg-light ps-4 pe-4">

                {{-- Include Page Content --}}
                @yield('content')

            </div>

        </main>

        {{-- include footer --}}
        @include('panels/store/footer')

        <!-- End: Content-->

        {{-- include default scripts --}}
        @include('panels/store/scripts')

        <script>

        </script>

    </body>
</html>
