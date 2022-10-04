@extends('layouts/store/contentLayoutMaster')

@section('title', 'Product Details')

@section('style')

<link rel="stylesheet" href="{{ asset(mix('css/store/smoothproducts.css')) }}">

@endsection

@section('content')

    <input type="hidden" id="name" name="name" value="{{$product->name}}">
    <input type="hidden" id="brand" name="brand" value="{{$product->brand}}">
    <input type="hidden" id="code" name="code" value="{{$product->code}}">
    <input type="hidden" id="price" name="price" value="{{$product->price}}">

    @if (Auth::guard('customer')->check())
        <input type="hidden" id="auth" name="auth" value="{{Auth::guard('customer')->user()->id}}">
    @else
        <input type="hidden" id="auth" name="auth" value="">
    @endif


    <br>
    <div class="row mb-1 mt-1">

        <div class="col-12 col-sm-12 col-md-4 col-lg-4 me-0 pe-0">

            <div class="sp-loading">
                <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                    <span class="visually-hidden">Loading Images...</span>
                </div>
                <br>Loading Images...
            </div>

            <div class="sp-wrap">

                @if(isset($product->thumbnail) && !empty($product->thumbnail) && $product->thumbnail)

                    @if (file_exists(public_path().'/productthumbnail/'.$product->thumbnail))

                        <a href="{{asset('productthumbnail/'.$product->thumbnail)}}"><img src="{{asset('productthumbnail/'.$product->thumbnail)}}" alt="thumbnail"></a>

                    @endif

                @endif

                @if (!empty($productimages->toArray()))

                    <?php $i = 1; ?>

                    @foreach ($productimages as $productimage)

                        @if (file_exists(public_path().'/productimages/'.$productimage->image))

                            <a href="{{asset('productimages/'.$productimage->image)}}"><img src="{{asset('productimages/'.$productimage->image)}}" alt="image-<?php echo $i; ?>"></a>

                            <?php $i++; ?>

                        @endif

                    @endforeach

                @endif

            </div>

        </div>


        <div class="col-12 col-sm-12 col-md-8 col-lg-8 ms-0 ps-0">
            <h2 class="mb-4">{{$product->name}}</h2>

            <h5 class="text-secondary"><i class="fa-solid fa-indian-rupee-sign"></i> {{$product->price}}</h5>

            <hr><br>

            <span class="text-dark mb-3"><strong>Brand: </strong>{{$product->brand}}</span>

            <div class="col-12 mb-3 border p-2 mt-5 overflow-scroll" style="height: 300px;">
                <p>

                    <?php echo $product->description; ?>

                </p>
            </div>

            <button type="button" onclick="addtocart({{$product->id}})" id="submit" class="btn btn-outline-dark mt-5" style="border-radius: 0%;" title="Product Details"><i class="fa-solid fa-cart-plus me-2"></i>ADD TO CART</button>
        </div>

    </div>

@endsection

@section('script')

<script src="{{ asset(mix('js/store/smoothproducts.js')) }}"></script>

{{-- wait for images to load --}}
<script type="text/javascript">
	$('.sp-wrap').smoothproducts();
</script>

{{-- for add to cart ajax --}}
<script>
    function addtocart(id)
    {
        var name = $("#name").val();
        var brand = $("#brand").val();
        var code = $("#code").val();
        var price = $("#price").val();

        var count = 0;
        var finalcount = 0;

        var auth = $("#auth").val();
        var url = '{{ route("cart",["id" =>  ":id"]) }}';
        var finalurl = url.replace(':id', auth);

        $.ajax({
            url: "{{ route('addtocart') }}",
            method: "POST",
            dataType: "json",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                name: name,
                brand: brand,
                code: code,
                price: price,
            },

            beforeSend: function () {
                $("#submit").prop("disabled", true);

                // add spinner to button
                $("#submit").html(
                    `<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Adding to cart...`
                );
            },

            success: function (response) {
                if (response == 0)
                {
                    new PNotify({text: 'Product added in cart.', styling: 'fontawesome', icon: 'fa-solid fa-cart-arrow-down', animateSpeed: 'fast', closer: false, delay: '3000', type: 'success'});
                }
                else if (response == 1)
                {
                    count = $('#main-cart-count').text();

                    ++count;

                    $('#main-cart-count').text(count);

                    $('#remove-click').prop("onclick", null);

                    $("#remove-click").prop("href", finalurl);

                    new PNotify({text: 'Product added in cart.', styling: 'fontawesome', icon: 'fa-solid fa-cart-arrow-down', animateSpeed: 'fast', closer: false, delay: '3000', type: 'success'});
                }
                else if (response == 2)
                {
                    new PNotify({text: 'Product not added in cart, Please login or register first.', styling: 'fontawesome', icon: 'fa-solid fa-person-circle-exclamation', animateSpeed: 'fast', closer: false, delay: '3000', type: 'warning'});

                    setTimeout(function () {
                        window.location = "/home/guest/login";
                    }, 1500);
                }
                else
                {
                    new PNotify({text: 'Product not added in cart !', styling: 'fontawesome', icon: 'fa-solid fa-triangle-exclamation', animateSpeed: 'fast', closer: false, delay: '3000', type: 'error'});
                }
            },

            error: function (xhr) {
                //alert(xhr.responseText);
            },

            complete: function () {
                $("#submit").prop("disabled", false);

                // add spinner to button
                $("#submit").html(
                    `<i class="fa-solid fa-cart-plus me-2"></i>ADD TO CART`
                );
            },

        });

    }
</script>

@endsection
