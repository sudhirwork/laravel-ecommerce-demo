@extends('layouts/store/contentLayoutMaster')

@section('title', 'Register')

@section('style')
    <link rel="stylesheet" href="{{ asset(mix('css/pnotify.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/select2.css')) }}">
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-lg">
        <div class="card-header">
            <h4 class="pt-2">Register</h4>
        </div>
        <div class="card-body">

            <form id="registerform" action="{{ route("registercustomer") }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="form-group col-md-6 mb-2">

                        <label for="first_name">First Name</label>

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

                        <label for="last_name">Last Name</label>

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

                        <label for="email">Email</label>

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

                        <label for="mobile">Mobile Number</label>

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

                        <label for="password">Password</label>

                        <input
                            type="password"
                            id="password"
                            class="remove_valid form-control"
                            name="password"
                            placeholder="Password"
                        />

                        <span class="remove_valid_error invalid-feedback" id="password_error"></span>

                    </div>

                    <div class="form-group col-md-6 mb-2">

                        <label for="password_confirmation">Confirm Password</label>

                        <input
                            type="password"
                            id="password_confirmation"
                            class="remove_valid form-control"
                            name="password_confirmation"
                            placeholder="Confirm Password"
                        />

                        <span class="remove_valid_error invalid-feedback" id="password_confirmation_error"></span>

                    </div>

                    <div class="form-group col-md-6 mb-2">

                        <label for="address_line_1">Address Line 1</label>

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

                        <label for="address_line_2">Address Line 2</label>

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

                        <label for="country">Select Country</label>

                        <select name="country" id="country" class="remove_valid form-control">
                        </select>

                        <span class="remove_valid_error invalid-feedback" id="country_error"></span>

                    </div>

                    <div class="form-group col-md-4 mb-2">

                        <label for="state">Select State</label>

                        <select name="state" id="state" class="remove_valid form-control" disabled>
                        </select>

                        <span class="remove_valid_error invalid-feedback" id="state_error"></span>

                    </div>

                    <div class="form-group col-md-4 mb-2">

                        <label for="city">Select City</label>

                        <select name="city" id="city" class="remove_valid form-control" disabled>
                        </select>

                        <span class="remove_valid_error invalid-feedback" id="city_error"></span>

                    </div>

                    <div class="form-group col-md-6 mb-2">

                        <label for="zipcode">Zip/Postal Code</label>

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

                    <div class="form-group col-md-6 mb-2">

                        <label for="profile_image">Profile Image</label>

                        <input
                            type="file"
                            class="remove_valid form-control"
                            id="profile_image"
                            name="profile_image"
                            accept="image/*"
                        />

                        <span class="remove_valid_error invalid-feedback" id="profile_image_error"></span>

                    </div>

                    <div class="col-12 mt-3 mb-3">

                        <button id="submit" onclick="checkvalidation()"  type="button" class="btn btn-primary text-white me-2">Register</button>

                        <button type="reset" class="btn btn-outline-warning">Reset</button>

                    </div>

                    <hr>

                    <div class="col-12 mb-2">

                        <div class="mb-1">
                            <span>Already have an account?</span>

                            @if ($form == 'user')

                                <a class="text-primary" style="text-decoration: none;" href="{{ route('loginform') }}">
                                    <span>  Log in instead  </span>
                                </a>

                            @else

                                <a class="text-primary" style="text-decoration: none;" href="{{ route('checkloginform') }}">
                                    <span>  Log in instead  </span>
                                </a>

                            @endif
                        </div>

                    </div>

                </div>

            </form>

        </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script src="{{ asset(mix('js/pnotify.min.js')) }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>

{{-- For Select2 --}}
<script type="text/javascript">
    $(document).ready(function() {

        // for country
        $("#country").select2({
            placeholder: "Search Country Here...",
            allowClear: true,
            ajax: {
                url: "{{ route('getcountry') }}",
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
                        url: "{{ route('getstate') }}?country="+country,
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
                        url: "{{ route('getcity') }}?state="+state,
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

    function checkvalidation()
    {
        PNotify.removeAll();

        var formData = new FormData($('#registerform')[0]);

        $.ajax({
            url: '{{ route("registercustomer") }}',
            type: 'POST',
            data: formData,
            beforeSend: function () {
                $("#submit").prop("disabled", true);

                // add spinner to button
                $("#submit").html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
                );
            },
            success: function (response) {
                $(".remove_valid").removeClass("is-invalid");
                $('.remove_valid_error').text('');

                new PNotify({title: response.success, styling: 'fontawesome', delay: '3000', type: 'success'});

                if (response.productid == 'blank')
                {
                    setTimeout(function () {
                        window.location = "/home";
                    }, 1500);
                }
                else
                {
                    setTimeout(function () {
                        window.location = "/product/productdetails/"+response.productid;
                    }, 1500);
                }
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

                if(response.responseJSON.errors.password)
                {
                    $("#password").addClass("is-invalid");
                    $('#password_error').text(response.responseJSON.errors.password);
                }
                else
                {
                    $("#password").removeClass("is-invalid");
                    $('#password_error').text('');
                }

                if(response.responseJSON.errors.password_confirmation)
                {
                    $("#password_confirmation").addClass("is-invalid");
                    $('#password_confirmation_error').text(response.responseJSON.errors.password_confirmation);
                }
                else
                {
                    $("#password_confirmation").removeClass("is-invalid");
                    $('#password_confirmation_error').text('');
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

                if(response.responseJSON.errors.profile_image)
                {
                    $("#profile_image").addClass("is-invalid");
                    $('#profile_image_error').text(response.responseJSON.errors.profile_image);
                }
                else
                {
                    $("#profile_image").removeClass("is-invalid");
                    $('#profile_image_error').text('');
                }
            },
            complete: function () {
                $("#submit").prop("disabled", false);

                // add spinner to button
                $("#submit").text(
                    `Register`
                );
            },
            cache: false,
            contentType: false,
            processData: false
        });

    }

</script>

@endsection
