<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title') - Store</title>

  <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon/favicon.ico')}}">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

  {{-- Include Styles --}}
  @include('panels/store/styles')

</head>

<body class="overflow-auto" style="padding-top: 40px; padding-bottom: 200px;">

    <!-- BEGIN: Content-->

    {{-- Include Navbar --}}
    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand text-center text-warning pt-2 ps-4 pe-4" style="padding: 1px;" href="{{route('home')}}"><h4><i class="fa-solid fa-shop"></i> Store</h4></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>

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
