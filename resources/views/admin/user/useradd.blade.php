@extends('layouts/admin/contentLayoutMaster')

@section('title', 'Add User')

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
            <h4 class="pt-2">Add User</h4>
        </div>
        <div class="card-body">

            <form id="userform" action="{{ route("userstore") }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                  <div class="col-md-6 col-6 mb-2">
                    <div class="form-group" id="name_div">
                      <label for="username">Name</label>
                      <input
                        type="text"
                        id="name"
                        class="form-control"
                        placeholder="Name"
                        name="name"
                      />
                    </div>
                  </div>

                  <div class="col-md-6 col-6 mb-2">
                    <div class="form-group" id="email_div">
                      <label for="email">Email Address</label>
                      <input
                        type="text"
                        id="email"
                        class="form-control"
                        placeholder="Email Address"
                        name="email"
                      />
                    </div>
                  </div>

                  <div class="col-md-6 col-6 mb-2">
                    <div class="form-group" id="password_div">
                      <label for="password">Password</label>
                      <div class="input-group">

                        <input
                            type="text"
                            id="password"
                            class="form-control"
                            placeholder="Password"
                            name="password"
                        />

                        <span class="input-group-text">
                            <a href="javascript:void(0)" class="" title="Generate Password" onclick="$('#password').val(randString())"><i class="fa-solid fa-rotate"></i></a>
                        </span>

                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 col-6 mb-2">
                    <div class="form-group" id="roles_div">

                      <label for="roles">Role</label>

                        <select class="form-select" id="roles" name="roles">

                            <option value="" selected>--- Select Role ---</option>

                            @foreach ($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach

                        </select>

                    </div>
                  </div>

                  <div class="col-12 mb-2">
                    <div class="form-group">
                        <ul class="list-unstyled mb-0">
                            <li class="d-inline-block" style="margin-right: 20px;">
                                <fieldset>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" value="1" name="status" id="customRadio1" checked="">
                                        <label class="form-check-label" for="customRadio1">Active</label>
                                    </div>
                                </fieldset>
                            </li>
                            <li class="d-inline-block">
                                <fieldset>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="status" value="0" id="customRadio2">
                                        <label class="form-check-label" for="customRadio2">Inactive</label>
                                    </div>
                                </fieldset>
                            </li>
                        </ul>
                    </div>
                  </div>

                  <div class="col-12 mt-2">

                    <button type="button" id="submit" onclick="checkvalidation()" class="btn btn-primary text-white">Add User</button>

                    <button type="reset" class="btn btn-outline-warning">Reset</button>

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

<script>
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });

    function checkvalidation() {
        var username = $("#name").val().trim();
        var email = $("#email").val().trim();
        var password = $("#password").val();
        var roles = $("#roles").val();

        var isvalidpassword = isvalidname = isvalidemail = isvalidroles = 0;

        PNotify.removeAll();

        if (username == '') {
            $("#name_div").addClass("has-error is-focused");
            new PNotify({title: 'Please enter name !', styling: 'fontawesome', delay: '3000', type: 'error'});
            isvalidname = 0;
        } else {
            isvalidname = 1;
        }
        if (email == '') {
            $("#email_div").addClass("has-error is-focused");
            new PNotify({title: 'Please enter email address !', styling: 'fontawesome', delay: '3000', type: 'error'});
            isvalidemail = 0;
        } else {
            if (!ValidateEmail(email)) {
                $("#email_div").addClass("has-error is-focused");
                new PNotify({title: 'Please enter valid email address !', styling: 'fontawesome', delay: '3000', type: 'error'});
                isvalidemail = 0;
            } else {
                $("#email_div").removeClass("has-error is-focused");
                isvalidemail = 1;
            }
        }




        if(password==''){
      $("#password_div").addClass("has-error is-focused");
      new PNotify({title: 'Please enter password !',styling: 'fontawesome',delay: '3000',type: 'error'});
      isvalidpassword = 0;
    }else{
      if(CheckPassword(password)==false){
        $("#password_div").addClass("has-error is-focused");
        new PNotify({title: 'Please enter password between 6 to 20 characters which contain at least one special character !',styling: 'fontawesome',delay: '3000',type: 'error'});
        isvalidpassword = 0;
      }else{
        $("#password_div").removeClass("has-error is-focused");
        isvalidpassword = 1;
      }
    }

    if (roles == '') {
            $("#roles_div").addClass("has-error is-focused");
            new PNotify({
                title: 'Please select role !',
                styling: 'fontawesome',
                delay: '3000',
                type: 'error'
            });
            isvalidroles = 0;
        } else {
            isvalidroles = 1;
        }


        if (isvalidpassword == 1 && isvalidname == 1 && isvalidemail == 1 && isvalidroles == 1) {
            var formData = new FormData($('#userform')[0]);


            $.ajax({
                url: '{{ route("userstore") }}',
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
                        new PNotify({title: "User successfully added.", styling: 'fontawesome', delay: '3000', type: 'success'});
                        setTimeout(function () {
                            window.location = "/admin/user";
                        }, 1500);

                    } else if (response == 2) {
                        new PNotify({title: "User E-Mail Already Exists.", styling: 'fontawesome', delay: '3000', type: 'error'});
                        $("#email_div").addClass("has-error is-focused");
                    } else {
                        new PNotify({title: 'User not added !', styling: 'fontawesome', delay: '3000', type: 'error'});
                    }
                },
                error: function (xhr) {
                    //alert(xhr.responseText);
                },
                complete: function () {
                    $("#submit").prop("disabled", false);
                    // add spinner to button
                    $("#submit").text(
                            `Add User`
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
