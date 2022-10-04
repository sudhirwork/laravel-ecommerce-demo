@extends('layouts/store/contentLayoutMaster')

@section('title', 'Change Password')

@section('style')
    <link rel="stylesheet" href="{{ asset(mix('css/pnotify.css')) }}">
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card shadow-lg">
        <div class="card-header">
            <h4 class="pt-2">Change Password</h4>
        </div>
        <div class="card-body">

            <form id="changepasswordform" action="{{ route("changeingpassword") }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="form-group col-md-12 mb-2">

                        <label for="current_password">Current Password</label>

                        <input
                            type="password"
                            id="current_password"
                            class="remove_valid form-control"
                            name="current_password"
                            placeholder="Current Password"
                        />

                        <span class="remove_valid_error invalid-feedback" id="current_password_error"></span>

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

                    <div class="col-12 mt-3 mb-3">

                        <button id="submit" onclick="checkvalidation()"  type="button" class="btn btn-primary text-white">Update Password</button>

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

        var formData = new FormData($('#changepasswordform')[0]);

        $.ajax({
            url: '{{ route("changeingpassword") }}',
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

                setTimeout(function () {
                    window.location = "/home";
                }, 1500);
            },
            error: function (response) {
                if(response.responseJSON.errors.current_password)
                {
                    $("#current_password").addClass("is-invalid");
                    $('#current_password_error').text(response.responseJSON.errors.current_password);
                }
                else
                {
                    $("#current_password").removeClass("is-invalid");
                    $('#current_password_error').text('');
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
                    `Update Password`
                );
            },
            cache: false,
            contentType: false,
            processData: false
        });

    }

</script>

@endsection
