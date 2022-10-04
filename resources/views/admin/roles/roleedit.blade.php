@extends('layouts/admin/contentLayoutMaster')

@section('title', 'Edit Role & Permissions')

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
            <h4 class="pt-2">Edit Role & Permissions</h4>
        </div>
        <div class="card-body">

            <form id="orgform" action="{{ route("roleupdate") }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" id="id" name="id" value="{{ old('id', isset($role) ? $role->id : '') }}">

                <div class="mt-2" id="namediv">
                    <label for="name">Role Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Role Name" value="{{ old('name', isset($role) ? $role->name : '') }}">
                </div>

                <h5 class="text-center mt-4">Permissions</h5>

                <div class="row" style="padding: 30px;" id="permissiondiv">

                    @foreach($permission as $permissions)

                        <div class="col-xl-2 col-lg-2 col-md-2 col-12 border pt-2 pb-2 mb-2" style="border-radius: 10px; margin-right: 52px;">

                            <div class="form-check form-switch">

                                <input
                                    type="checkbox"
                                    role="switch"
                                    name="permission[]"
                                    value="{{$permissions->id}}" @if(in_array($permissions->id, $rolePermissions)) ? checked : '') @endif
                                    class="form-check-input permission"
                                    id="customSwitch{{$permissions->id}}"
                                />

                                <label class="form-check-label" for="customSwitch{{ $permissions->id }}">{{$permissions->name}}
                                </label>

                            </div>

                        </div>

                    @endforeach

                </div>


                <div class="col-12 text-center mb-1">

                    <button type="button" onclick="checkvalidation()" id="submit" class="btn btn-primary text-white">Update Role & Permissions</button>

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

            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

        }

    });

    function checkvalidation()
    {
        var name = $("#name").val();
        var permission = $(".permission").val();

        var isvalidname = isvalidpermission = 0;

        PNotify.removeAll();

        if (name == '')
        {
            $("#namediv").addClass("has-error is-focused");
            new PNotify({title: 'Please enter role name !', styling: 'fontawesome', delay: '3000', type: 'error'});
            isvalidname = 0;
        }
        else
        {
            isvalidname = 1;
        }

        if (permission == '')
        {
            $("#permissiondiv").addClass("has-error is-focused");
            new PNotify({title: 'Please select permissions !', styling: 'fontawesome', delay: '3000', type: 'error'});
            isvalidpermission = 0;
        }
        else
        {
            isvalidpermission = 1;
        }

        if (isvalidname == 1 && isvalidpermission == 1)
        {
            var formData = new FormData($('#orgform')[0]);

            $.ajax({
                url: '{{ route("roleupdate") }}',
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
                        new PNotify({title: "Role & Permissions successfully Updated.", styling: 'fontawesome', delay: '3000', type: 'success'});
                        setTimeout(function () {
                            window.location = "/admin/roles/role";
                        }, 1500);

                    } else {
                        new PNotify({title: "Role Name Already Exists.", styling: 'fontawesome', delay: '3000', type: 'error'});
                        $("#namediv").addClass("has-error is-focused");
                    }
                },
                error: function (xhr) {
                    //alert(xhr.responseText);
                },
                complete: function () {
                    $("#submit").prop("disabled", false);
                    // add spinner to button
                    $("#submit").text(
                        `Update Role & Permissions`
                    );
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

    }

</script>

@endsection
