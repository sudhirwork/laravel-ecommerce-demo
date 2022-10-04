@extends('layouts/store/fullLayoutMaster')

@section('title', 'Reset Failed')

@section('style')
@endsection

@section('content')

@if (Session::has('fail'))
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <i class="fa-solid fa-circle-exclamation fa-lg"></i> &nbsp;
        <div>
            {{ Session::get('fail') }}
        </div>
    </div>
@endif

@endsection

@section('script')
@endsection
