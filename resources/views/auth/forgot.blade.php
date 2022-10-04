@extends('layouts/admin/fullLayoutMaster')

@section('title', 'Forgot')

@section('style')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">

@endsection

@section('content')

<form method="POST" action="{{ route('forgotpassword') }}">

    @csrf

    {{-- <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> --}}

    <h1 class="text-warning border rounded p-1 bg-secondary"><i class="fa-solid fa-shop"></i> Store</h1>
    <br>
    <h1 class="h5 mb-3 fw-normal"><i class="fa-solid fa-unlock-keyhole"></i>  Forgot Password</h1>

    <div class="has-validation">

        <div class="form-floating @error('email') is-invalid @enderror">

        <input type="text" style="border-radius: 10px;" class="form-control @error('email') is-invalid @enderror" name="email" id="floatingInput" placeholder="name@example.com" autofocus value="{{ old('email') }}">

        <label for="floatingInput">Email Address</label>

        </div>

        @error('email')
            <div class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </div>
        @enderror

    </div>

    <div class="mb-3 mt-3">
        <a class="text-primary" style="text-decoration: none;" href="{{ route('login') }}">
            <p><i class="fa-regular fa-circle-left"></i> Back to login</p>
        </a>
    </div>

    <button class="w-100 btn btn-lg btn-primary text-white" type="submit"><i class="fa-solid fa-paper-plane fa-xs"></i> Send</button>

    <p class="mt-5 mb-3 text-muted">COPYRIGHT &copy; {{ now()->year }} <a class="text-primary" style="text-decoration: none;" href="{{route('home')}}" target="_blank">Store</a>, All rights Reserved</p>

</form>

@endsection
