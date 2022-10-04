@extends('layouts/store/contentLayoutMaster')

@section('title', 'Profile')

@section('style')

@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card mb-3 shadow-lg">

            <div class="row g-0">

                <div class="col-md-4 position-relative" style="padding-top: 200px; padding-bottom: 200px;">

                    @if (isset($customer->profile_image) && !empty($customer->profile_image))

                        @if (!file_exists(public_path().'/customerprofile/'.$customer->profile_image))

                            <div class="text-white text-center rounded-circle position-absolute top-50 start-50 translate-middle position-relative" style="height: 300px; width: 300px; background-color: #B8B3F6; border: 4px solid #ffffff83;">
                                <i class="fa-regular fa-face-smile fa-10x position-absolute top-50 start-50 translate-middle"></i>
                            </div>

                        @else

                            <img src="{{asset('customerprofile/'.$customer->profile_image)}}" width="300" height="300" class="img-fluid rounded-circle position-absolute top-50 start-50 translate-middle" alt="image" style="border: 4px solid #ffffff83;">

                        @endif

                    @elseif (isset($customer->first_name) && !empty($customer->first_name))

                        <div class="text-white text-center rounded-circle position-absolute top-50 start-50 translate-middle position-relative" style="height: 300px; width: 300px; background-color: #B8B3F6; border: 4px solid #ffffff83;">
                            <i class="fa-regular fa-<?php echo strtolower(substr($customer->first_name,0,1)) ?> fa-10x position-absolute top-50 start-50 translate-middle"></i>
                        </div>

                    @else

                        <div class="text-white text-center rounded-circle position-absolute top-50 start-50 translate-middle position-relative" style="height: 300px; width: 300px; background-color: #B8B3F6; border: 4px solid #ffffff83;">
                            <i class="fa-regular fa-face-smile fa-10x position-absolute top-50 start-50 translate-middle"></i>
                        </div>

                    @endif

                </div>

                <div class="col-md-8 border-start">

                    <div class="card-body">

                        <ul class="list-group">

                            <li class="list-group-item list-group-item-dark">Account Details</li>

                            <li class="list-group-item"><strong>Name: </strong>{{$customer->first_name}} {{$customer->last_name}}</li>

                            <li class="list-group-item"><strong>Email: </strong>{{$customer->email}}</li>

                            <li class="list-group-item"><strong>Mobile: </strong>{{$customer->mobile}}</li>

                            <li class="list-group-item"><strong>Address: </strong><small>{{$customer->address_line_1}}</small><br><small>{{$customer->address_line_2}}</small></li>

                            <li class="list-group-item"><strong>Zip/Postal Code: </strong>{{$customer->zipcode}}</li>

                            <li class="list-group-item"><strong>City: </strong>{{$city->name}}</li>

                            <li class="list-group-item"><strong>State: </strong>{{$state->name}}</li>

                            <li class="list-group-item"><strong>Country: </strong>{{$country->name}}</li>

                        </ul>

                    </div>

                </div>

                <div class="col-md-12 border-top pt-3 pb-3">
                    <center>
                        <a href="{{route('customerprofileedit')}}" class="text-decoration-none"><button type="button" class="btn btn-primary text-white d-block btn-lg"><i class="fa-solid fa-edit"></i>&nbsp; Edit Profile</button></a>
                    </center>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection

@section('script')

@endsection
