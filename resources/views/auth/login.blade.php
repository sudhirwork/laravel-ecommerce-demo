@extends('layouts/admin/fullLayoutMaster')

@section('title', 'Login')

@section('style')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">

@endsection

@section('content')

<form method="POST" action="{{ route('authenticate') }}">

    @csrf

    {{-- <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> --}}

    <h1 class="text-warning border rounded p-1 bg-secondary"><i class="fa-solid fa-shop"></i> Store</h1>
    <br>

    @if (Session::has('success'))
        <div style="padding:15px;" class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
            <i class="fa-regular fa-circle-check"></i> <small><strong>{{ Session::get('success') }}</strong>, Check Your Mail And Log In.</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h1 class="h5 mb-3 fw-normal">Admin Log In</h1>

    <div class="has-validation">

        <div class="form-floating @error('email') is-invalid @enderror">

        <input type="text" class="form-control @error('email') is-invalid @enderror" style="border-radius: 10px 10px 0px 0px;" name="email" id="floatingInput" placeholder="name@example.com" autofocus value="{{ old('email') }}">

        <label for="floatingInput">Email Address</label>

        </div>

        @error('email')
            <div class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </div>
        @enderror

    </div>

    <div class="form-floating">

      <input type="password" class="form-control" style="border-radius: 0px 0px 10px 10px;" id="floatingPassword" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">

      <label for="floatingPassword">Password</label>

    </div>

    <div class="form-check mb-1">
      <label>

        <input type="checkbox" class="form-check-input" name="remember-me" id="custom-check" value="remember-me" {{ old('remember-me') ? 'checked' : '' }}>

        <label class="form-check-label" for="custom-check">
            Remember me
        </label>

      </label>
    </div>

    <div class="mb-3">
        <a class="text-primary" style="text-decoration: none;" href="{{ route('forgot') }}">
            <small>Forgot Password ?</small>
        </a>
    </div>

    <button class="w-100 btn btn-lg btn-primary text-white" type="submit"><i class="fa-solid fa-arrow-right-to-bracket fa-xs"></i> Log In</button>

    <p class="mt-5 mb-3 text-muted">COPYRIGHT &copy; {{ now()->year }} <a class="text-primary" style="text-decoration: none;" href="{{route('home')}}" target="_blank">Store</a>, All rights Reserved</p>

</form>

@endsection
