@extends('layouts/admin/contentLayoutMaster')

@section('title', 'Add Product')

@section('style')

 <link rel="stylesheet" href="{{ asset(mix('css/pnotify.css')) }}">
 <link rel="stylesheet" href="{{ asset(mix('css/select2.css')) }}">

 {{-- for editor --}}
 <link rel="stylesheet" href="{{ asset('css/katex.min.css') }}">
 <link rel="stylesheet" href="{{ asset('css/monokai-sublime.min.css') }}">
 <link rel="stylesheet" href="{{ asset(mix('css/quill.snow.css')) }}">
 <link rel="preconnect" href="https://fonts.gstatic.com">
 <link href="https://fonts.googleapis.com/css2?family=Inconsolata&family=Roboto+Slab&family=Slabo+27px&family=Sofia&family=Ubuntu+Mono&display=swap" rel="stylesheet">

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
            <h4 class="pt-2">Add Product</h4>
        </div>
        <div class="card-body">

            <form id="orgform" action="{{ route("productstore") }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="form-group col-md-6 mb-2" id="catid_div">

                        <label for="catid">Select Category</label>

                        <select name="catid" id="catid" class="form-control">
                        </select>

                    </div>

                    <div class="form-group col-md-6 mb-2" id="name_div">

                        <label for="name">Product Name</label>

                        <input
                            type="text"
                            id="name"
                            class="form-control"
                            name="name"
                            placeholder="Product Name"
                            value="{{ old('name', isset($product) ? $product->name : '') }}"
                        />

                    </div>

                    <div class="form-group col-md-6 mb-2" id="brand_div">

                        <label for="brand">Product Brand</label>

                        <input
                            type="text"
                            id="brand"
                            class="form-control"
                            name="brand"
                            placeholder="Product Brand"
                            value="{{ old('brand', isset($product) ? $product->brand : '') }}"
                        />

                    </div>

                    <div class="form-group col-md-6 mb-2" id="code_div">

                        <label for="code">Product Code</label>

                        <input
                            type="text"
                            id="code"
                            class="form-control"
                            name="code"
                            placeholder="Product Code"
                            value="{{ old('code', isset($product) ? $product->code : '') }}"
                        />

                    </div>

                    <div class="form-group col-md-6 mb-2" id="qty_div">

                        <label for="qty">Product Stock Quantity</label>

                        <input
                            type="number"
                            id="qty"
                            min="1"
                            step="1"
                            class="form-control"
                            name="qty"
                            placeholder="Product Stock Quantity"
                            value="{{ old('qty', isset($product) ? $product->stock_quantity : '') }}"
                        />

                    </div>

                    <div class="form-group col-md-6 mb-2" id="price_div">

                        <label for="price">Product Price</label>

                        <div class="input-group">

                            <span class="input-group-text"><i class="fa-solid fa-indian-rupee-sign"></i></span>

                            <input
                                type="number"
                                id="price"
                                min="1"
                                step="1"
                                class="form-control"
                                name="price"
                                placeholder="Product Price"
                                value="{{ old('price', isset($product) ? $product->price : '') }}"
                            />

                        </div>

                    </div>

                    <div class="form-group col-md-12 mb-2" id="description_div">

                        <label for="description">Project Description</label>

                        <div id="full-wrapper">
                            <div id="full-container" style="height: auto;" class="description_div">
                              <div class="editor">

                              </div>
                            </div>
                        </div>

                        <textarea
                            id="description"
                            name="description"
                            style="display: none;"
                        ></textarea>

                    </div>

                    <div class="form-group col-md-6 mb-2" id="thumbnail_div">

                        <label for="thumbnail">Product Thumbnail</label>

                            <input
                            type="file"
                            class="form-control"
                            id="thumbnail"
                            name="thumbnail"
                            accept="image/*"
                            />

                    </div>

                    <div class="form-group col-md-6 mb-2" id="image_div">

                        <label for="image">Product Images</label>

                            <input
                            type="file"
                            class="form-control"
                            id="image"
                            name="image[]"
                            accept="image/*"
                            multiple
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

                        <button id="submit" onclick="checkvalidation()"  type="button" class="btn btn-primary text-white">Add Product</button>

                        <button type="reset" class="btn btn-outline-warning">Reset</button>

                    </div>

                </div>

            </form>

        </div>
        </div>
    </div>
</div>

{{-- for editor custom css --}}
<style>

    .ql-container {
        min-height: 100px;
    }

</style>

<style>.alert-success{background-color:#3CB371 !important}.alert-danger{background-color: red !important; }.has-error input, .has-error select, .has-error textarea, .has-error .custom-file-label{border: 1px solid red !important;border-color: red !important;}</style>

@endsection

@section('script')
    <script src="{{ asset(mix('js/pnotify.min.js')) }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>

    {{-- for editor --}}
    <script src="{{ asset('js/katex.min.js') }}"></script>
    <script src="{{ asset('js/highlight.min.js') }}"></script>
    <script src="{{ asset('js/quill.min.js') }}"></script>

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
                if ($(this).get(0).files[0].size > (524288000))
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

        // for thumbnail
        $("#thumbnail").change(function () {
            // Get uploaded file extension
            var extension = $(this).val().split('.').pop().toLowerCase();

            // Create array with the files extensions that we wish to upload
            var validFileExtensions = ['apng', 'avif', 'gif', 'jpg', 'jpeg', 'jfif', 'pjpeg', 'pjp', 'png', 'svg', 'webp', 'bmp', 'ico', 'cur', 'tif', 'tiff'];

            //Check file extension in the array.if -1 that means the file extension is not in the list.
            if ($.inArray(extension, validFileExtensions) == -1)
            {
                $("#thumbnail_div").addClass("has-error is-focused");

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
                if ($(this).get(0).files[0].size > (524288000))
                {
                    $("#thumbnail_div").addClass("has-error is-focused");

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

                    $("#thumbnail_div").removeClass("has-error is-focused");

                    //Enable Submit Button
                    $('#submit').prop('disabled', false);
                }
            }
        });
    });
</script>

{{-- For Select2 Category --}}
<script type="text/javascript">
    $(document).ready(function() {

        // for Category
        $("#catid").select2({
            placeholder: "Search Category Here...",
            allowClear: true,
            ajax: {
                url: "{{ route('getallcategory') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchCat: params.term || '', // search category
                        page: params.page || 1
                    };
                },
                cache: true
            }
        });

    });
</script>

{{-- for details quill snow editor --}}
<script type="text/javascript">

    var fullEditor = new Quill('#full-container .editor', {
        bounds: '#full-container .editor',
        modules: {
        formula: true,
        syntax: true,
        toolbar: [
            [
            {
                font: []
            },
            {
                size: []
            }
            ],
            ['bold', 'italic', 'underline', 'strike'],
            [
            {
                color: []
            },
            {
                background: []
            }
            ],
            [
            {
                script: 'super'
            },
            {
                script: 'sub'
            }
            ],
            [
            {
                header: '1'
            },
            {
                header: '2'
            },
            'blockquote',
            'code-block'
            ],
            [
            {
                list: 'ordered'
            },
            {
                list: 'bullet'
            },
            {
                indent: '-1'
            },
            {
                indent: '+1'
            }
            ],
            [
            'direction',
            {
                align: []
            }
            ],
            ['link', 'image', 'video', 'formula'],
            ['clean']
        ]
        },
        placeholder: 'Product Description',
        theme: 'snow'
    });

    var description = $("#description").val();

    const value = description;

    const delta = fullEditor.clipboard.convert(value);

    fullEditor.setContents(delta, 'silent');

</script>

<script>
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

        }

    });

    function checkvalidation()
    {
        var catid = $("#catid").val();
        var name = $("#name").val();
        var brand = $("#brand").val();
        var code = $("#code").val().trim();
        var qty = $("#qty").val().trim();
        var price = $("#price").val().trim();
        var editor = $('.editor>div').html();
        var description = $("#description").val($('.editor>div').html()); // $('.ql-editor').html()
        var thumbnail = $("#thumbnail")[0].files.length;
        var image = $("#image")[0].files.length;

        PNotify.removeAll();

        if (catid == null)
        {
            $("#catid_div").addClass("has-error is-focused");
            new PNotify({
                title: 'Please select category !',
                styling: 'fontawesome',
                delay: '3000',
                type: 'error'
            });
            var isvalidcatid = 0;
        }
        else
        {
            var isvalidcatid = 1;
        }

        if (name == '')
        {
            $("#name_div").addClass("has-error is-focused");
            new PNotify({title: 'Please enter product name !', styling: 'fontawesome', delay: '3000', type: 'error'});
            var isvalidname = 0;
        }
        else
        {
            var isvalidname = 1;
        }

        if (brand == '')
        {
            $("#brand_div").addClass("has-error is-focused");
            new PNotify({title: 'Please enter product brand !', styling: 'fontawesome', delay: '3000', type: 'error'});
            var isvalidbrand = 0;
        }
        else
        {
            var isvalidbrand = 1;
        }

        if (code == '')
        {
            $("#code_div").addClass("has-error is-focused");
            new PNotify({title: 'Please enter product code !', styling: 'fontawesome', delay: '3000', type: 'error'});
            var isvalidcode = 0;
        }
        else
        {
            var isvalidcode = 1;
        }

        if (qty == '')
        {
            $("#qty_div").addClass("has-error is-focused");
            new PNotify({title: 'Please enter product stock quantity !', styling: 'fontawesome', delay: '3000', type: 'error'});
            var isvalidqty = 0;
        }
        else
        {
            if (!ValidateValue(qty))
            {
                $("#qty_div").addClass("has-error is-focused");
                new PNotify({
                    title: 'Please enter only numeric value !',
                    styling: 'fontawesome',
                    delay: '3000',
                    type: 'error'
                });
                var isvalidqty = 0;
            }
            else
            {
                $("#qty_div").removeClass("has-error is-focused");
                var isvalidqty = 1;
            }
        }

        if (price == '')
        {
            $("#price_div").addClass("has-error is-focused");
            new PNotify({title: 'Please enter product price !', styling: 'fontawesome', delay: '3000', type: 'error'});
            var isvalidprice = 0;
        }
        else
        {
            if (!ValidateValue(price))
            {
                $("#price_div").addClass("has-error is-focused");
                new PNotify({
                    title: 'Please enter only numeric value !',
                    styling: 'fontawesome',
                    delay: '3000',
                    type: 'error'
                });
                var isvalidprice = 0;
            }
            else
            {
                $("#price_div").removeClass("has-error is-focused");
                var isvalidprice = 1;
            }
        }

        if (editor == '<p><br></p>')
        {
            $("#description_div").addClass("has-error is-focused");
            new PNotify({title: 'Please enter product description !', styling: 'fontawesome', delay: '3000', type: 'error'});
            var isvalideditor = 0;
        }
        else
        {
            var isvalideditor = 1;
        }

        if (thumbnail === 0)
        {
            $("#thumbnail_div").addClass("has-error is-focused");
            new PNotify({title: 'Please Select Product Thumbnail !', styling: 'fontawesome', delay: '3000', type: 'error'});
            var isvaildthumbnail = 0;
        }
        else
        {
            var isvaildthumbnail = 1;
        }

        if (image === 0)
        {
            $("#image_div").addClass("has-error is-focused");
            new PNotify({title: 'Please Select Product Images !', styling: 'fontawesome', delay: '3000', type: 'error'});
            var isvalidimage = 0;
        }
        else
        {
            var isvalidimage = 1;
        }

        if (isvalidcatid == 1 && isvalidname == 1 && isvalidbrand == 1 && isvalidcode == 1 && isvalidqty == 1 && isvalidprice == 1 && isvalideditor == 1 && isvaildthumbnail == 1 && isvalidimage == 1)
        {
            var formData = new FormData($('#orgform')[0]);

            $.ajax({
                url: '{{ route("productstore") }}',
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
                        new PNotify({title: "Product successfully added.", styling: 'fontawesome', delay: '3000', type: 'success'});
                        setTimeout(function () {
                            window.location = "/admin/product";
                        }, 1500);
                    }
                    else if (response == 2)
                    {
                        $("#code_div").addClass("has-error is-focused");

                        new PNotify({title: 'Product code already exists, please try with another product or product code !', styling: 'fontawesome', delay: '3000', type: 'error'});
                    }
                    else
                    {
                        new PNotify({title: 'Product not added !', styling: 'fontawesome', delay: '3000', type: 'error'});
                    }
                },
                error: function (xhr) {
                    //alert(xhr.responseText);
                },
                complete: function () {
                    $("#submit").prop("disabled", false);
                    // add spinner to button
                    $("#submit").text(
                            `Add Product`
                            );
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

    }

    function ValidateValue(val)
    {
        var pettrn = /^[0-9]+$/;

        if (pettrn.test(val)) {
            return true;
        }

        return false;
    }

</script>

@endsection
