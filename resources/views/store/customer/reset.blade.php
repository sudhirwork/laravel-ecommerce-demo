@extends('layouts/store/fullLayoutMaster')

@section('title', 'Reset Password')

@section('style')
    <link rel="stylesheet" href="{{ asset(mix('css/pnotify.css')) }}">
@endsection

@section('content')

<div class="row">
    <div class="col-sm-1 col-md-4 col-lg-4"></div>
    <div class="col-sm-10 col-md-4 col-lg-4">
        <div class="card shadow-lg">
        <div class="card-header text-center">
            <h4 class="pt-2"><i class="fa-solid fa-lock"></i>&nbsp; Reset Password</h4>
        </div>
        <div class="card-body">

            <form id="resetform" action="{{ route("customerresetpassword") }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group col-md-12 mb-2">

                        <label for="email">Email</label>

                        <input
                            type="text"
                            id="email"
                            class="remove_valid form-control"
                            name="email"
                            placeholder="Email"
                            value="{{$email->email}}"
                            autofocus
                            readonly
                        />

                        <span class="remove_valid_error invalid-feedback" id="email_error"></span>

                    </div>

                    <div class="form-group col-md-6 mb-2">

                        <label for="new_password">New Password</label>

                        <input
                            type="password"
                            id="new_password"
                            class="remove_valid form-control"
                            name="new_password"
                            placeholder="New Password"
                        />

                        <span class="remove_valid_error invalid-feedback" id="new_password_error"></span>

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

                    <div class="col-12 text-center mt-3">

                        <button id="submit" onclick="checkvalidation()"  type="button" class="btn btn-primary text-white">Set New Password</button>

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

        var formData = new FormData($('#resetform')[0]);

        $.ajax({
            url: '{{ route("customerresetpassword") }}',
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

                if(response.success)
                {
                    new PNotify({title: response.success, styling: 'fontawesome', delay: '3000', type: 'success'});

                    setTimeout(function () {
                        window.location = "/home/login";
                    }, 1500);
                }
                else
                {
                    new PNotify({title: response.error_token, styling: 'fontawesome', delay: '3000', type: 'error'});
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

                if(response.responseJSON.errors.new_password)
                {
                    $("#new_password").addClass("is-invalid");
                    $('#new_password_error').text(response.responseJSON.errors.new_password);
                }
                else
                {
                    $("#new_password").removeClass("is-invalid");
                    $('#new_password_error').text('');
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
            },
            complete: function () {
                $("#submit").prop("disabled", false);

                // add spinner to button
                $("#submit").text(
                    `Set New Password`
                );
            },
            cache: false,
            contentType: false,
            processData: false
        });

    }

</script>

@endsection
