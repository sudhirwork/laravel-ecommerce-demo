@extends('layouts/store/contentLayoutMaster')

@section('title', 'My Order')

@section('style')

@endsection

@section('content')

    <div class="row">

        <div class="col-6">
            <div class="list-group" id="list-tab" role="tablist">

                @foreach ($orders as $order)

                    <a class="list-group-item list-group-item-action <?php if($order1->id == $order->id){ echo 'active'; } ?>" id="list-{{$order->id}}-list" data-bs-toggle="list" href="#list-{{$order->id}}" role="tab" aria-controls="list-{{$order->id}}">

                        <div class="d-flex w-100 justify-content-between">
                            <div>
                                <h5 class="mb-1">{{$order->name}}</h5>
                                @if ($order->track_status == 'deliverd')
                                    <strong class="mb-1 text-success">{{ucfirst($order->track_status)}}</strong>
                                @else
                                    <strong class="mb-1 text-warning">{{ucfirst($order->track_status)}}</strong>
                                @endif
                            </div>

                            <img style="height:50px; width:50px;" class="border rounded-3 img-fluid" src="{{asset('productthumbnail/'.$order->thumbnail)}}" alt="Thumbnail" title="Product Thumbnail">
                        </div>

                    </a>

                @endforeach

            </div>
        </div>

        <div class="col-6">
            <div class="tab-content" id="nav-tabContent">

                @foreach ($orders as $order)

                    @php
                        $country = DB::table('countries')->find($order->country);
                        $state = DB::table('states')->find($order->state);
                        $city = DB::table('cities')->find($order->city);
                    @endphp

                    <div class="tab-pane fade show <?php if($order1->id == $order->id){ echo 'active'; } ?>" id="list-{{$order->id}}" role="tabpanel" aria-labelledby="list-{{$order->id}}-list">
                        <div class="row">

                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="card">

                                    <div class="card-header border border-dark">
                                      Order Details
                                    </div>

                                    <ul class="list-group list-group-flush">

                                      <li class="list-group-item"><strong>Order Number: </strong><span class="text-success">{{$order->order_no}}</span></li>

                                      <li class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <div><strong>Product Name: </strong>{{$order->name}}
                                            </div>
                                            <a class="text-primary text-decoration-none" href="{{route('productdetails', ['id' => $order->id_product])}}"><i class="fa-solid fa-circle-chevron-right"></i></a>
                                        </div>
                                      </li>

                                      <li class="list-group-item"><strong>Product Brand: </strong>{{$order->brand}}</li>

                                      <li class="list-group-item"><strong>Tracking: </strong>
                                        @if ($order->track_status == 'deliverd')
                                            <span class="badge rounded-pill text-bg-success">{{ucfirst($order->track_status)}}</span>
                                        @else
                                            <span class="badge rounded-pill text-bg-warning">{{ucfirst($order->track_status)}}</span>
                                        @endif
                                      </li>

                                      <li class="list-group-item border border-dark" style="background-color: #F7F7F7">Payment Details</li>

                                      <li class="list-group-item"><strong>Price: </strong><i class="fa-solid fa-indian-rupee-sign fa-sm"></i> {{$order->price}}</li>

                                      <li class="list-group-item"><strong>Quantity: </strong>{{$order->quantity}}</li>

                                      <li class="list-group-item"><strong>Subtotal <small>(Price × Quantity)</small>:</strong> <i class="fa-solid fa-indian-rupee-sign fa-sm"></i> {{$order->subtotal}}</li>

                                      <li class="list-group-item border-success border text-success"><strong>Total: </strong><i class="fa-solid fa-indian-rupee-sign fa-sm"></i> {{$order->subtotal}}</li>

                                    </ul>

                                </div>
                            </div>

                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="card">

                                    <div class="card-header border border-dark">
                                      Shipping Details
                                    </div>

                                    <ul class="list-group list-group-flush">

                                      <li class="list-group-item"><strong>Name: </strong>{{$order->first_name}} {{$order->last_name}}</li>

                                      <li class="list-group-item"><strong>Email: </strong>{{$order->email}}</li>

                                      <li class="list-group-item"><strong>Mobile: </strong>{{$order->mobile}}</li>

                                      <li class="list-group-item border border-dark" style="background-color: #F7F7F7">Shipping Address</li>

                                      <li class="list-group-item"><small class="text-muted">{{$order->address_line_1}}</small><br><small class="text-muted">{{$order->address_line_2}}</small></li>

                                      <li class="list-group-item"><strong>Zip/Postal Code: </strong>{{$order->zipcode}}</li>

                                      <li class="list-group-item"><strong>City: </strong>{{$city->name}}</li>

                                      <li class="list-group-item"><strong>State: </strong>{{$state->name}}</li>

                                      <li class="list-group-item"><strong>Country: </strong>{{$country->name}}</li>

                                    </ul>

                                </div>
                            </div>

                        </div>
                    </div>

                @endforeach

            </div>
        </div>

    </div>

@endsection

@section('script')

@endsection
