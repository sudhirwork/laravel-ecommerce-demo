@extends('layouts/store/contentLayoutMaster')

@section('title', 'Forgot Password')

@section('style')
    <link rel="stylesheet" href="{{ asset(mix('css/pnotify.css')) }}">
@endsection

@section('content')

<div class="row">
    <div class="col-sm-1 col-md-4 col-lg-4"></div>
    <div class="col-sm-10 col-md-4 col-lg-4">
        <div class="card shadow-lg">
        <div class="card-header text-center">
            <h4 class="pt-2"><i class="fa-solid fa-unlock-keyhole"></i>&nbsp; Forgot Password</h4>
        </div>
        <div class="card-body">

            <form id="forgotform" action="{{ route("forgotcustomer") }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="form-group col-md-12 mb-2">

                        <label for="email">Email</label>

                        <input
                            type="text"
                            id="email"
                            class="remove_valid form-control"
                            name="email"
                            placeholder="Email"
                        />

                        <span class="remove_valid_error invalid-feedback" id="email_error"></span>

                    </div>

                    <div class="col-12 mt-3 mb-3 text-center">

                        <button id="submit" onclick="checkvalidation()"  type="button" class="btn btn-primary text-white"><i class="fa-solid fa-paper-plane fa-sm"></i> Send</button>

                    </div>

                    <hr>

                    <div class="col-12 text-center">

                        <a class="text-primary" style="text-decoration: none;" href="{{ route('loginform') }}">
                            <p><i class="fa-regular fa-circle-left"></i> Back to login</p>
                        </a>

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

        var formData = new FormData($('#forgotform')[0]);

        $.ajax({
            url: '{{ route("forgotcustomer") }}',
            type: 'POST',
            data: formData,
            beforeSend: function () {
                $("#submit").prop("disabled", true);

                // add spinner to button
                $("#submit").html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...`
                );
            },
            success: function (response) {
                $(".remove_valid").removeClass("is-invalid");
                $('.remove_valid_error').text('');

                new PNotify({title: response.success, styling: 'fontawesome', delay: '3000', type: 'success'});

                setTimeout(function () {
                    window.location = "/home/login";
                }, 1500);
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
            },
            complete: function () {
                $("#submit").prop("disabled", false);

                // add spinner to button
                $("#submit").html(
                    `<i class="fa-solid fa-paper-plane fa-sm"></i> Send`
                );
            },
            cache: false,
            contentType: false,
            processData: false
        });

    }

</script>

@endsection
