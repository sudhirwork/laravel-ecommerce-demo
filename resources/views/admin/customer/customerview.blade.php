@extends('layouts/admin/contentLayoutMaster')

@section('title', 'View Customer')

@section('content')
{{-- breadcrumb-start --}}
<div class="row">

    <div class="col-10 text-left">
        <h3>@yield('title')</h3>
    </div>

    <div class="col-2 text-right">

    </div>

    <div class="col-12 mt-1 mb-3">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            @if(@isset($breadcrumbs))
            <ol class="breadcrumb">
                {{-- this will load breadcrumbs dynamically from controller --}}
                @foreach ($breadcrumbs as $breadcrumb)
                <li class="breadcrumb-item">
                    @if(isset($breadcrumb['link']))
                    <a href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link']:url($breadcrumb['link']) }}">
                        @endif
                        {{$breadcrumb['name']}}
                        @if(isset($breadcrumb['link']))
                    </a>
                    @endif
                </li>
                @endforeach
            </ol>
            @endisset
        </nav>
    </div>

</div>
{{-- breadcrumb-end --}}

<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="pt-2">Customer Details</h4>
            </div>
            <div class="card-body">

                <ul class="list-group">

                    @if(isset($customer->profile_image) && !empty($customer->profile_image) && $customer->profile_image)

                        @if (!file_exists(public_path().'/customerprofile/'.$customer->profile_image))

                            <li class="list-group-item"><strong>Profile Image: </strong><div class="text-white text-center rounded-3 m-0" style="height: 45px; width: 45px; padding-top: 11px; background-color: #B8B3F6;"><i class="fa-regular fa-face-smile fa-2xl"></i></div></li>

                        @else

                            <li class="list-group-item"><strong>Profile Image: </strong><div><img class="rounded-3 img-fluid" style="height:45px; width:45px;" src="{{asset('customerprofile/'.$customer->profile_image)}}" alt="image"></div></li>

                        @endif

                    @elseif (isset($customer->first_name) && !empty($customer->first_name) && $customer->first_name)

                        <li class="list-group-item"><strong>Profile Image: </strong><div class="text-white text-center rounded-3 m-0" style="height: 45px; width: 45px; padding-top: 11px; background-color: #B8B3F6;"><i class="fa-regular fa-<?php echo strtolower(substr($customer->first_name,0,1)) ?> fa-2xl"></i></div></li>

                    @else

                        <li class="list-group-item"><strong>Profile Image: </strong><div class="text-white text-center rounded-3 m-0" style="height: 45px; width: 45px; padding-top: 11px; background-color: #B8B3F6;"><i class="fa-regular fa-face-smile fa-2xl"></i></div></li>

                    @endif

                    <li class="list-group-item"><strong>Full Name: </strong><?php echo $customer->first_name.' '.$customer->last_name; ?></li>

                    <li class="list-group-item"><strong>Email: </strong><?php echo $customer->email; ?></li>

                    <li class="list-group-item"><strong>Mobile No.: </strong><?php echo $customer->mobile; ?></li>

                    <li class="list-group-item"><strong>Address Line 1: </strong><?php echo $customer->address_line_1; ?></li>

                    <li class="list-group-item"><strong>Address Line 2: </strong><?php echo $customer->address_line_2; ?></li>

                    <li class="list-group-item"><strong>City: </strong><?php echo $city->name; ?></li>

                    <li class="list-group-item"><strong>State: </strong><?php echo $state->name; ?></li>

                    <li class="list-group-item"><strong>Country: </strong><?php echo $country->name; ?></li>

                    <li class="list-group-item"><strong>Zip/Postal Code: </strong><?php echo $customer->zipcode; ?></li>

                </ul>

            </div>
        </div>
    </div>

</div>

@endsection
