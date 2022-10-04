@extends('layouts/admin/contentLayoutMaster')

@section('title', 'Add Category')

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
            <h4 class="pt-2">Add Category</h4>
        </div>
        <div class="card-body">

            <form id="orgform" action="{{ route("categorystore") }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="form-group col-md-12 mb-2" id="name_div">

                        <label for="name">Category Name</label>

                        <input
                            type="text"
                            id="name"
                            class="form-control"
                            name="name"
                            placeholder="Category Name"
                        />

                    </div>

                    <div class="form-group col-md-12 mb-2">
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

                    <div class="col-12 mt-2">

                        <button id="submit" onclick="checkvalidation()"  type="button" class="btn btn-primary text-white">Add Category</button>

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

            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

        }

    });

    function checkvalidation()
    {
        var name = $("#name").val();

        PNotify.removeAll();

        if (name == '')
        {
            $("#name_div").addClass("has-error is-focused");
            new PNotify({title: 'Please enter Category Name !', styling: 'fontawesome', delay: '3000', type: 'error'});
            var isvalidname = 0;
        }
        else
        {
            var isvalidname = 1;
        }

        if (isvalidname == 1)
        {
            var formData = new FormData($('#orgform')[0]);

            $.ajax({
                url: '{{ route("categorystore") }}',
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
                    if (response == 1)
                    {
                        new PNotify({title: "Category successfully added.", styling: 'fontawesome', delay: '3000', type: 'success'});
                        setTimeout(function () {
                            window.location = "/admin/category";
                        }, 1500);
                    }
                    else if (response == 2)
                    {
                        $("#name_div").addClass("has-error is-focused");

                        new PNotify({title: 'Category name already exists, please try with another category name !', styling: 'fontawesome', delay: '3000', type: 'error'});
                    }
                    else
                    {
                        new PNotify({title: 'Category not added !', styling: 'fontawesome', delay: '3000', type: 'error'});
                    }
                },
                error: function (xhr) {
                    //alert(xhr.responseText);
                },
                complete: function () {
                    $("#submit").prop("disabled", false);
                    // add spinner to button
                    $("#submit").text(
                            `Add Category`
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
