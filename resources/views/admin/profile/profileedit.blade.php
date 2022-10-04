@extends('layouts/admin/contentLayoutMaster')

@section('title', 'Edit Admin Profile')

@section('style')

 <link rel="stylesheet" href="{{ asset(mix('css/pnotify.css')) }}">

@endsection

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
            <h4 class="pt-2">Edit Admin Profile</h4>
        </div>
        <div class="card-body">

            <form id="orgform" action="{{ route("adminprofileupdate") }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" id="id" name="id" value="{{ old('id', isset($admin) ? $admin->id : '') }}">

                <div class="row">
                    <div class="col-6 mb-2" id="name_div">
                        <div class="form-group">
                            <label for="name">Admin Name</label>
                            <input type="text" id="name" class="form-control" name="name" placeholder="Admin Name" value="{{ old('name', isset($admin) ? $admin->name : '') }}">


                            @if($errors->has('name'))
                            <em class="invalid-feedback">
                                {{ $errors->name }}
                            </em>
                            @endif
                        </div>
                    </div>
                    <div class="col-6 mb-2" id="email_div">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="text" id="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email', isset($admin) ? $admin->email : '') }}">

                            @if ($errors->any())
                            <div class="help-block"><ul role="alert"><li>{{ $errors->first('email') }}</li></ul></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6 mb-2" id="password_div">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group">

                                <input id="password" type="text" name="password" class="form-control" tabindex="7" placeholder="Leave if not change">

                                <span class="input-group-text">
                                    <a href="javascript:void(0)" class="" title="Generate Password" onclick="$('#password').val(randString())"><i class="fa-solid fa-rotate"></i></a>
                                </span>

                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-2" id="image_div">
                        <div class="form-group">
                            <label for="password">Profile Image</label>

                            <input name="profile_image" type="file" class="form-control" id="image" accept="image/*">

                            <?php if(isset($admin->profile_image) && !empty($admin->profile_image)){ ?>
                                <center>
                                    <img class="rounded-3 img-fluid" width="80" src="{{url('/adminprofile/'.$admin->profile_image)}}" alt="Image">
                                </center>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <button onclick="checkvalidation()" id="submit"  type="button" class="btn btn-primary text-white">Update Admin Profile</button>
                    </div>
                </div>

            </form>

        </div>
        </div>
    </div>
</div>

<style>.alert-success{background-color:#3CB371 !important}.alert-danger{background-color: red !important; }.has-error input, .has-error select, .has-error textarea, .has-error .custom-file-label{border: 1px solid red !important;border-color: red !important;}</style>

@endsection

@section('script')
    <script src="{{ asset(mix('js/pnotify.min.js')) }}"></script>

    {{-- for file input validation size, extention, etc --}}
    <script type="text/javascript">
        $(document).ready(function () {
            // for image
            $("#image").change(function () {
                // Get uploaded file extension
                var extension = $(this).val().split('.').pop().toLowerCase();

                // Create array with the files extensions that we wish to upload
                var validFileExtensions = ['apng', 'avif', 'gif', 'jpg', 'jpeg', 'jfif', 'pjpeg', 'pjp', 'png', 'svg', 'webp', 'bmp', 'ico', 'cur', 'tif', 'tiff'];

                //Check file extension in the array.if -1 that means the file extension is not in the list.
                if ($.inArray(extension, validFileExtensions) == -1)
                {
                    $("#image_div").addClass("has-error is-focused");

                    new PNotify({title: 'Upload only [apng, avif, gif, jpg, jpeg, jfif, pjpeg, pjp, png, svg, webp, bmp, ico, cur, tif, tiff] file', styling: 'fontawesome', delay: '3000', type: 'error'});

                    // Clear fileuload control selected file
                    $(this).replaceWith($(this).val('').clone(true));

                    $(this).next('.custom-file-label').html('Choose file');

                    //Disable Submit Button
                    $('#submit').prop('disabled', true);
                }
                else
                {
                    // Check and restrict the file size to 50 MB.
                    if ($(this).get(0).files[0].size > (52428800))
                    {
                        $("#image_div").addClass("has-error is-focused");

                        new PNotify({title: 'file size is big, upload files below 50mb', styling: 'fontawesome', delay: '3000', type: 'error'});

                        // Clear fileuload control selected file
                        $(this).replaceWith($(this).val('').clone(true));

                        $(this).next('.custom-file-label').html('Choose file');

                        //Disable Submit Button
                        $('#submit').prop('disabled', true);
                    }
                    else
                    {
                        //Clear and Hide message span
                        // PNotify.removeAll();

                        $("#image_div").removeClass("has-error is-focused");

                        //Enable Submit Button
                        $('#submit').prop('disabled', false);
                    }
                }
            });
        });
    </script>

    <script>
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            }

        });

        function checkvalidation()
        {
            var name = $("#name").val().trim();
            var email = $("#email").val().trim();

            var isvalidname = isvalidemail = 0;

            PNotify.removeAll();

            if (name == '')
            {
                $("#name_div").addClass("has-error is-focused");
                new PNotify({title: 'Please enter name !', styling: 'fontawesome', delay: '3000', type: 'error'});
                isvalidname = 0;
            }
            else
            {
                isvalidname = 1;
            }
            if (email == '')
            {
                $("#email_div").addClass("has-error is-focused");
                new PNotify({title: 'Please enter email address !', styling: 'fontawesome', delay: '3000', type: 'error'});
                isvalidemail = 0;
            }
            else
            {
                isvalidemail = 1;
            }

            if (isvalidname == 1 && isvalidemail == 1) {
                var formData = new FormData($('#orgform')[0]);

                $.ajax({
                    url: '{{ route("adminprofileupdate") }}',
                    type: 'POST',
                    data: formData,
                    //async: false,
                    beforeSend: function () {
                        $("#submit").prop("disabled", true);
                        // add spinner to button
                        $("#submit").html(
                                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
                                );
                    },
                    success: function (response) {
                        if (response == 1) {
                            new PNotify({title: "Admin Profile successfully Updated.", styling: 'fontawesome', delay: '3000', type: 'success'});
                            setTimeout(function () {
                                window.location = "/admin/dashboard";
                            }, 1500);

                        } else if (response == 2) {
                            new PNotify({title: "Admin Email already exists.", styling: 'fontawesome', delay: '3000', type: 'error'});
                            $("#email_div").addClass("has-error is-focused");
                        } else {
                            new PNotify({title: 'Admin Profile not Updated !', styling: 'fontawesome', delay: '3000', type: 'error'});
                        }
                    },
                    error: function (xhr) {
                        //alert(xhr.responseText);
                    },
                    complete: function () {
                        $("#submit").prop("disabled", false);
                        // add spinner to button
                        $("#submit").text(
                                `Update Admin Profile`
                                );
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }

        }

        function randString(len = 8) {

            var possible = '';
            possible += 'abcdefghijklmnopqrstuvwxyz';
            possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            possible += '0123456789';
            possible += '!{}()%&*$#^@';

            var text = '';
            for (var i = 0; i < len; i++) {
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            }
            return text;
        }

        function ValidateEmail(mail) {
            //var res = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            var res = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (res.test(mail)) {
                return true;
            }
            return false;
        }

        function CheckPassword(inputtxt)
        {
            var passw = /^(?=.*[!@#$%_''""/=(){}\^\&*-.\?])[a-zA-Z0-9!@#$%_''""/=(){}\^\&*-.\?]{6,20}$/;
            if(inputtxt.match(passw)){
            return true;
            }else{
            return false;
            }
        }
    </script>

@endsection
