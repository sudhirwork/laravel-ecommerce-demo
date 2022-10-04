@extends('layouts/store/contentLayoutMaster')

@section('title', 'Login')

@section('style')
    <link rel="stylesheet" href="{{ asset(mix('css/pnotify.css')) }}">
@endsection

@section('content')

<div class="row">
    <div class="col-sm-1 col-md-4 col-lg-4"></div>
    <div class="col-sm-10 col-md-4 col-lg-4">
        <div class="card shadow-lg">
        <div class="card-header text-center">
            <h4 class="pt-2">Login</h4>
        </div>
        <div class="card-body">

            <form id="loginform" action="{{ route("logincustomer") }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="form-group col-md-12 mb-2">

                        <label for="email">Email</label>

                        <input
                            type="text"
                            id="email"
                            class="remove_valid form-control"
                            name="email"
                            placeholder="name@example.com"
                        />

                        <span class="remove_valid_error invalid-feedback" id="email_error"></span>

                    </div>

                    <div class="form-group col-md-12 mb-2">

                        <label for="password">Password</label>

                        <input
                            type="password"
                            id="password"
                            class="remove_valid form-control"
                            name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        />

                        <span class="remove_valid_error invalid-feedback" id="password_error"></span>

                    </div>

                    <div class="col-md-6 mb-2 text-left">

                        <div class="form-check mb-1">
                            <label>

                              <input type="checkbox" class="form-check-input" name="remember-me" id="custom-check" value="remember-me" {{ old('remember-me') ? 'checked' : '' }}>

                              <label class="form-check-label" for="custom-check">
                                  Remember me
                              </label>

                            </label>
                        </div>

                    </div>

                    <div class="col-md-6 mb-2 text-right">

                        <div class="mb-1">
                            <a class="text-primary" style="text-decoration: none;" href="{{ route('forgotcustomerform') }}">
                                <small>Forgot Password ?</small>
                            </a>
                        </div>

                    </div>

                    <div class="col-12 mt-2 mb-3 text-center">

                        <button id="submit" onclick="checkvalidation()"  type="button" class="btn btn-primary text-white">Login</button>

                    </div>

                    <hr>

                    <div class="col-12 mb-2 text-center">

                        <div class="mb-1">
                            <span>New on our platform?</span>

                            @if ($form == 'user')

                                <a class="text-primary" style="text-decoration: none;" href="{{ route('registerform') }}">
                                    <span> Create an account </span>
                                </a>

                            @else

                                <a class="text-primary" style="text-decoration: none;" href="{{ route('checkregisterform') }}">
                                    <span> Create an account </span>
                                </a>

                            @endif
                        </div>

                    </div>

                </div>

            </form>

        </div>
        </div>
    </div>
    <div class="col-sm-1 col-md-4 col-lg-4"></div>
</div>

@endsection

@section('script')
    <script src="{{ asset(mix('js/pnotify.min.js')) }}"></script>

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

        var formData = new FormData($('#loginform')[0]);

        $.ajax({
            url: '{{ route("logincustomer") }}',
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
                if(response.success)
                {
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
                }
                else
                {
                    $("#email").addClass("is-invalid");
                    $("#password").addClass("is-invalid");

                    new PNotify({title: response.error_login, styling: 'fontawesome', delay: '3000', type: 'error'});
                }
            },
            error: function (response) {
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
            },
            complete: function () {
                $("#submit").prop("disabled", false);

                // add spinner to button
                $("#submit").text(
                    `Login`
                );
            },
            cache: false,
            contentType: false,
            processData: false
        });

    }

</script>

@endsection
