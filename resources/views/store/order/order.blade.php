@extends('layouts/store/contentLayoutMaster')

@section('title', 'Checkout')

@section('style')

<link rel="stylesheet" href="{{ asset(mix('css/select2.css')) }}">

@endsection

@section('content')

<div class="row g-5">

    <div class="col-12 col-md-12 col-lg-12 border-bottom mb-0 mt-4 rounded text-center pt-3 pb-3" style="background-color: #ffffff">
        <h2 class="text-muted">Checkout</h2>
    </div>

    @if (!empty($carts->toArray()))

        <div class="col-md-7 col-lg-8 mt-0 pt-3 border" style="background-color: #ffffff">

            <h4 class="mb-3 text-primary">Billing address</h4>

            <form id="orderform" action="{{ route("placeorder") }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    @foreach ($carts as $cart)

                        <input type="hidden" name="addmore[{{$cart->cartid}}][id_cart]" value="{{$cart->cartid}}">

                        <input type="hidden" name="addmore[{{$cart->cartid}}][id_product]" value="{{$cart->id_product}}">

                        <input type="hidden" name="addmore[{{$cart->cartid}}][name]" value="{{$cart->name}}">

                        <input type="hidden" name="addmore[{{$cart->cartid}}][brand]" value="{{$cart->brand}}">

                        <input type="hidden" name="addmore[{{$cart->cartid}}][code]" value="{{$cart->code}}">

                        <input type="hidden" name="addmore[{{$cart->cartid}}][price]" value="{{$cart->price}}">

                        <input type="hidden" name="addmore[{{$cart->cartid}}][quantity]" value="{{$cart->quantity}}">

                        <input type="hidden" name="addmore[{{$cart->cartid}}][subtotal]" value="{{$cart->subtotal}}">

                    @endforeach

                    <input type="hidden" name="total" value="{{$total}}">

                    <input type="hidden" name="customerid" value="{{$customer->id}}">

                    <div class="form-group col-md-6 mb-2">

                        <label for="first_name" class="form-label">First Name</label>

                        <input
                            type="text"
                            id="first_name"
                            class="remove_valid form-control"
                            name="first_name"
                            placeholder="First Name"
                            value="{{ old('first_name', isset($customer) ? $customer->first_name : '') }}"
                        />

                        <span class="remove_valid_error invalid-feedback" id="first_name_error"></span>

                    </div>

                    <div class="form-group col-md-6 mb-2">

                        <label for="last_name" class="form-label">Last Name</label>

                        <input
                            type="text"
                            id="last_name"
                            class="remove_valid form-control"
                            name="last_name"
                            placeholder="Last Name"
                            value="{{ old('last_name', isset($customer) ? $customer->last_name : '') }}"
                        />

                        <span class="remove_valid_error invalid-feedback" id="last_name_error"></span>

                    </div>

                    <div class="form-group col-md-6 mb-2">

                        <label for="email" class="form-label">Email</label>

                        <input
                            type="text"
                            id="email"
                            class="remove_valid form-control"
                            name="email"
                            placeholder="Email"
                            value="{{ old('email', isset($customer) ? $customer->email : '') }}"
                        />

                        <span class="remove_valid_error invalid-feedback" id="email_error"></span>

                    </div>

                    <div class="form-group col-md-6 mb-2">

                        <label for="mobile" class="form-label">Mobile Number</label>

                        <input
                            type="number"
                            id="mobile"
                            min="1"
                            step="1"
                            class="remove_valid form-control"
                            name="mobile"
                            placeholder="Mobile Number"
                            value="{{ old('mobile', isset($customer) ? $customer->mobile : '') }}"
                        />

                        <span class="remove_valid_error invalid-feedback" id="mobile_error"></span>

                    </div>

                    <div class="form-group col-md-6 mb-2">

                        <label for="address_line_1" class="form-label">Address Line 1</label>

                        <input
                            type="text"
                            id="address_line_1"
                            class="remove_valid form-control"
                            name="address_line_1"
                            placeholder="Address Line 1"
                            value="{{ old('address_line_1', isset($customer) ? $customer->address_line_1 : '') }}"
                        />

                        <span class="remove_valid_error invalid-feedback" id="address_line_1_error"></span>

                    </div>

                    <div class="form-group col-md-6 mb-2">

                        <label for="address_line_2" class="form-label">Address Line 2</label>

                        <input
                            type="text"
                            id="address_line_2"
                            class="remove_valid form-control"
                            name="address_line_2"
                            placeholder="Address Line 2"
                            value="{{ old('address_line_2', isset($customer) ? $customer->address_line_2 : '') }}"
                        />

                        <span class="remove_valid_error invalid-feedback" id="address_line_2_error"></span>

                    </div>

                    <div class="form-group col-md-4 mb-2">

                        <label for="country" class="form-label">Select Country</label>

                        <select name="country" id="country" class="remove_valid form-control">
                            <option value="{{$country->id}}" selected>{{$country->name}}</option>
                        </select>

                        <span class="remove_valid_error invalid-feedback" id="country_error"></span>

                    </div>

                    <div class="form-group col-md-4 mb-2">

                        <label for="state" class="form-label">Select State</label>

                        <select name="state" id="state" class="remove_valid form-control">
                            <option value="{{$state->id}}" selected>{{$state->name}}</option>
                        </select>

                        <span class="remove_valid_error invalid-feedback" id="state_error"></span>

                    </div>

                    <div class="form-group col-md-4 mb-2">

                        <label for="city" class="form-label">Select City</label>

                        <select name="city" id="city" class="remove_valid form-control">
                            <option value="{{$city->id}}" selected>{{$city->name}}</option>
                        </select>

                        <span class="remove_valid_error invalid-feedback" id="city_error"></span>

                    </div>

                    <div class="form-group col-md-12 mb-2">

                        <label for="zipcode" class="form-label">Zip/Postal Code</label>

                        <input
                            type="number"
                            id="zipcode"
                            min="1"
                            step="1"
                            class="remove_valid form-control"
                            name="zipcode"
                            placeholder="Zip/Postal Code"
                            value="{{ old('zipcode', isset($customer) ? $customer->zipcode : '') }}"
                        />

                        <span class="remove_valid_error invalid-feedback" id="zipcode_error"></span>

                    </div>

                </div>

                <hr class="my-4">

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="same-address">
                    <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="save-info">
                    <label class="form-check-label" for="save-info">Save this information for next time</label>
                </div>

                <hr class="my-4">

                <h4 class="mb-3 text-primary">Payment</h4>

                <div class="my-3">
                    <div class="form-check">
                        <input id="cod" name="pm" type="radio" class="form-check-input" value="cod" checked>
                        <label class="form-check-label" for="cod">Cash on deliver (COD)</label>
                    </div>
                    <div class="form-check">
                        <input id="cc" name="pm" type="radio" class="form-check-input" value="cc">
                        <label class="form-check-label" for="cc">Credit card</label>
                    </div>
                    <div class="form-check">
                        <input id="dc" name="pm" type="radio" class="form-check-input" value="dc">
                        <label class="form-check-label" for="dc">Debit card</label>
                    </div>
                    <div class="form-check">
                        <input id="nb" name="pm" type="radio" class="form-check-input" value="nb">
                        <label class="form-check-label" for="nb">Net banking</label>
                    </div>
                </div>

            </form>

        </div>

        <div class="col-md-5 col-lg-4 mt-0 pt-3 border">

            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Product</span>
                <span class="badge bg-danger rounded-pill">{{$count}}</span>
            </h4>

            <ul class="list-group mb-3">

                @foreach ($carts as $cart)

                    <li class="list-group-item d-flex justify-content-between lh-sm">

                        <div>

                            <a href="#" class="text-decoration-none"><h6 class="my-0">{{$cart->name}}</h6></a>

                            <small class="text-muted">{{$cart->brand}}</small>

                            <br>

                            <small class="text-muted"><i class="fa-solid fa-indian-rupee-sign fa-xs"></i>{{$cart->price}} × {{$cart->quantity}}</small>

                        </div>

                        <span class="text-muted"><i class="fa-solid fa-indian-rupee-sign fa-sm"></i> {{$cart->subtotal}}</span>

                    </li>

                @endforeach

            </ul>

            <ul class="list-group mb-3">

                <li class="list-group-item d-flex justify-content-between">
                    <span>Subtotal</span>
                    <span class="text-muted"><i class="fa-solid fa-indian-rupee-sign fa-sm"></i> {{$total}}</span>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    <span>Shipping <span class="text-success">(Free)</span></span>
                    <span class="text-muted"><i class="fa-solid fa-indian-rupee-sign fa-sm"></i> 0</span>
                </li>

                <li class="list-group-item d-flex justify-content-between bg-light border-success border-top">
                    <span class="text-success">Total payable amount</span>
                    <strong class="text-success"><i class="fa-solid fa-indian-rupee-sign fa-sm"></i> {{$total}}</strong>
                </li>

            </ul>

            <div class="d-grid mt-2 mb-0 text-center">
                <button onclick="placeorder()" class="btn btn-success btn-lg mb-2 mt-1 text-white" type="button" style="border-radius: 5px;" title="Place order" id="submit"><i class="fa-solid fa-truck-arrow-right me-2"></i>Place order</button>

                <a href="{{route('cart', ['id' => $customer->id])}}" style="border-radius: 5px;" class="btn btn-outline-warning btn-lg"><i class="fa-solid fa-circle-arrow-left"></i>&nbsp; Back to cart</a>
            </div>

            <div class="row mt-4">
                <span class="col-12 col-sm-12 col-md-4 col-md-4 text-muted text-center">
                    <i class="fa-solid fa-shield"></i>&nbsp; Safe & Secure Payment
                </span>
                <span class="col-12 col-sm-12 col-md-4 col-md-4 text-muted text-center">
                    <i class="fa-solid fa-anchor"></i>&nbsp; 100% Buyer Protection
                </span>
                <span class="col-12 col-sm-12 col-md-4 col-md-4 text-muted text-center">
                    <i class="fa-solid fa-rotate-left"></i>&nbsp; Easy Returns & Refunds
                </span>
            </div>

            <div class="d-grid mt-4 text-center">
                <a href="{{route('product', ['value' => 'list'])}}" class="text-decoration-none">
                    <i class="fa-solid fa-store"></i>&nbsp; Continue Shopping
                </a>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-center mt-5 align-self-end">
                <i class="fa-brands fa-cc-mastercard fa-xl"></i>
                <i class="fa-brands fa-cc-discover fa-xl"></i>
                <i class="fa-brands fa-cc-jcb fa-xl"></i>
                <i class="fa-brands fa-cc-paypal fa-xl"></i>
                <i class="fa-brands fa-cc-stripe fa-xl"></i>
                <i class="fa-brands fa-cc-visa fa-xl"></i>
                <i class="fa-brands fa-cc-amazon-pay fa-xl"></i>
                <i class="fa-brands fa-cc-amex fa-xl"></i>
                <i class="fa-brands fa-cc-apple-pay fa-xl"></i>
                <i class="fa-brands fa-cc-diners-club fa-xl"></i>
            </div>

        </div>

    @else

        <div class="col-12 col-md-12 col-lg-12 mt-0 pt-4 pb-5 border text-center">
            <h4 class="text-danger pb-3 pt-3">Your cart is empty, Please add product in cart first.</h4>

            <a href="{{route('product', ['value' => 'list'])}}" class="text-decoration-none pb-5">
                <i class="fa-solid fa-circle-arrow-left"></i>&nbsp; Continue Shopping
            </a>
        </div>

    @endif

</div>

@endsection

@section('script')
<script src="{{ asset('js/select2.full.min.js') }}"></script>

{{-- For Select2 --}}
<script type="text/javascript">
    $(document).ready(function() {

        // for country
        $("#country").select2({
            placeholder: "Search Country Here...",
            allowClear: true,
            ajax: {
                url: "{{ route('getallcountry') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchcountry: params.term || '', // search country
                        page: params.page || 1
                    };
                },
                cache: true
            }
        });

        // for state
        $('#country').on('change', function () {
            // get country id
            var country = $(this).val();

            if (country == '')
            {
                $("#state").attr("disabled", "disabled");
                $('#state').html('');
                $('#city').html('');
            }
            else
            {
                $("#state").removeAttr("disabled");
                $('#state').html('');
                $('#city').html('');

                $("#state").select2({
                    placeholder: "Search State Here...",
                    allowClear: true,
                    ajax: {
                        url: "{{ route('getallstate') }}?country="+country,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                searchstate: params.term || '', // search state
                                page: params.page || 1
                            };
                        },
                        cache: true
                    }
                });
            }
        });

        // for city
        $('#state').on('change', function () {
            // get state id
            var state = $(this).val();

            if (state == '')
            {
                $("#city").attr("disabled", "disabled");
                $('#city').html('');
            }
            else
            {
                $("#city").removeAttr("disabled");
                $('#city').html('');

                $("#city").select2({
                    placeholder: "Search City Here...",
                    allowClear: true,
                    ajax: {
                        url: "{{ route('getallcity') }}?state="+state,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                searchcity: params.term || '', // search city
                                page: params.page || 1
                            };
                        },
                        cache: true
                    }
                });
            }
        });

    });
</script>

{{-- for ajax --}}
<script>
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

        }

    });

    function placeorder()
    {
        PNotify.removeAll();

        var formData = new FormData($('#orderform')[0]);

        $.ajax({
            url: '{{ route("placeorder") }}',
            type: 'POST',
            data: formData,
            beforeSend: function () {
                $("#submit").prop("disabled", true);

                // add spinner to button
                $("#submit").html(
                    `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Placing order...`
                );
            },
            success: function (response) {
                $(".remove_valid").removeClass("is-invalid");
                $('.remove_valid_error').text('');

                new PNotify({title: response.success, styling: 'fontawesome', delay: '3000', type: 'success'});

                setTimeout(function () {
                    window.location = "/product/list";
                }, 1500);
            },
            error: function (response) {
                if(response.responseJSON.errors.first_name)
                {
                    $("#first_name").addClass("is-invalid");
                    $('#first_name_error').text(response.responseJSON.errors.first_name);
                }
                else
                {
                    $("#first_name").removeClass("is-invalid");
                    $('#first_name_error').text('');
                }

                if(response.responseJSON.errors.last_name)
                {
                    $("#last_name").addClass("is-invalid");
                    $('#last_name_error').text(response.responseJSON.errors.last_name);
                }
                else
                {
                    $("#last_name").removeClass("is-invalid");
                    $('#last_name_error').text('');
                }

                if(response.responseJSON.errors.email)
                {
                    $("#email").addClass("is-invalid");
                    $('#email_error').text(response.responseJSON.errors.email);
                }
                else
                {
                    $("#email").removeClass("is-invalid");
                    $('#email_error').text('');
                }

                if(response.responseJSON.errors.mobile)
                {
                    $("#mobile").addClass("is-invalid");
                    $('#mobile_error').text(response.responseJSON.errors.mobile);
                }
                else
                {
                    $("#mobile").removeClass("is-invalid");
                    $('#mobile_error').text('');
                }

                if(response.responseJSON.errors.address_line_1)
                {
                    $("#address_line_1").addClass("is-invalid");
                    $('#address_line_1_error').text(response.responseJSON.errors.address_line_1);
                }
                else
                {
                    $("#address_line_1").removeClass("is-invalid");
                    $('#address_line_1_error').text('');
                }

                if(response.responseJSON.errors.address_line_2)
                {
                    $("#address_line_2").addClass("is-invalid");
                    $('#address_line_2_error').text(response.responseJSON.errors.address_line_2);
                }
                else
                {
                    $("#address_line_2").removeClass("is-invalid");
                    $('#address_line_2_error').text('');
                }

                if(response.responseJSON.errors.country)
                {
                    $("#country").addClass("is-invalid");
                    $('#country_error').text(response.responseJSON.errors.country);
                }
                else
                {
                    $("#country").removeClass("is-invalid");
                    $('#country_error').text('');
                }

                if(response.responseJSON.errors.state)
                {
                    $("#state").addClass("is-invalid");
                    $('#state_error').text(response.responseJSON.errors.state);
                }
                else
                {
                    $("#state").removeClass("is-invalid");
                    $('#state_error').text('');
                }

                if(response.responseJSON.errors.city)
                {
                    $("#city").addClass("is-invalid");
                    $('#city_error').text(response.responseJSON.errors.city);
                }
                else
                {
                    $("#city").removeClass("is-invalid");
                    $('#city_error').text('');
                }

                if(response.responseJSON.errors.zipcode)
                {
                    $("#zipcode").addClass("is-invalid");
                    $('#zipcode_error').text(response.responseJSON.errors.zipcode);
                }
                else
                {
                    $("#zipcode").removeClass("is-invalid");
                    $('#zipcode_error').text('');
                }
            },
            complete: function () {
                $("#submit").prop("disabled", false);

                // add spinner to button
                $("#submit").html(
                    `<i class="fa-solid fa-truck-arrow-right me-2"></i>Place order`
                );
            },
            cache: false,
            contentType: false,
            processData: false
        });

    }

</script>
@endsection
