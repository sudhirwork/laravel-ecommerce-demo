@extends('layouts/store/contentLayoutMaster')

@section('title', 'Cart')

@section('style')

<link rel="stylesheet" href="{{ asset(mix('css/store/cart.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/store/qty.css')) }}">
<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">

@endsection

@section('content')

<section class="shopping-cart dark">
    <div class="container">
       <div class="block-heading">
         <h2 class="text-primary">Cart <span class="badge bg-danger rounded-pill" id="count-item">{{$count}}</span></h2>
       </div>
       <div class="content shadow-lg">
            <div class="row position-relative" id="main-cart-area">

                @if (!empty($carts->toArray()))

                    <div class="col-md-12 col-lg-8 pe-0 cart-area">
                        <div class="items">

                            @foreach ($carts as $cart)

                                <div class="product border-top border-bottom product-area" id="product-area-{{$cart->cartid}}">
                                    <div class="row">
                                        <div class="col-md-3">

                                            @if(isset($cart->thumbnail) && !empty($cart->thumbnail) && $cart->thumbnail)

                                                @if (file_exists(public_path().'/productthumbnail/'.$cart->thumbnail))

                                                    <img style="height:155px; width:155px;" class="border rounded-3 img-fluid mx-auto d-block image" src="{{asset('productthumbnail/'.$cart->thumbnail)}}" alt="Thumbnail" title="Product Thumbnail">

                                                @else

                                                    <div style="height:155px; width:155px;" class="position-relative border rounded-3 bg-secondary img-fluid mx-auto d-block image" title="Product Thumbnail">

                                                        <h6 class="position-absolute top-50 start-50 translate-middle text-white"><strong>Product Thumbnail</strong></h6>

                                                    </div>

                                                @endif

                                            @else

                                                <div style="height:155px; width:155px;" class="position-relative border rounded-3 bg-secondary img-fluid mx-auto d-block image" title="Product Thumbnail">

                                                    <h6 class="position-absolute top-50 start-50 translate-middle text-white"><strong>Product Thumbnail</strong></h6>

                                                </div>

                                            @endif

                                        </div>

                                        <div class="col-md-9">
                                            <div class="info">
                                                <div class="row">

                                                    <div class="col-md-4 product-name">
                                                        <div class="product-name">

                                                            <a href="{{route('productdetails', ['id' => $cart->id])}}" class="text-decoration-none text-primary h5">{{$cart->name}}</a>

                                                            <div class="product-info">

                                                                <div><small>Brand: <span class="value">{{$cart->brand}}</span></small></div>

                                                                <div><small><span class="value"><i class="fa-solid fa-indian-rupee-sign"></i> {{$cart->price}}</span></small></div>

                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="quantity buttons_added">
                                                            <input type="button" value="-" class="minus" /><input
                                                                data-id="{{$cart->cartid}}"
                                                                id="quantity"
                                                                type="number"
                                                                min="1"
                                                                max="{{$cart->stock_quantity}}"
                                                                step="1"
                                                                value="{{$cart->quantity}}"
                                                                name="quantity[]"
                                                                placeholder="Qty"
                                                                class="input-text qty text input-quantity"
                                                                readonly
                                                            /><input type="button" value="+" class="plus" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 text-center price">
                                                        <span class="subtotal" id="span-subtotal-{{$cart->cartid}}"><i class="fa-solid fa-indian-rupee-sign"></i> {{$cart->subtotal}}</span>

                                                        <input id="subtotal-{{$cart->cartid}}" type="hidden" value="{{$cart->subtotal}}" class="sum-subtotal">
                                                    </div>

                                                    <div class="col-md-1 position-relative">
                                                        <a data-id="{{$cart->cartid}}"  href="javascript:;" class="position-absolute top-50 start-0 translate-middle-y text-danger deleteRecord"><i class="fa-regular fa-circle-xmark fa-2xl"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4 ps-0 cart-area">
                        <div class="summary">
                            <h3>Summary</h3>

                            <div class="summary-item"><span class="text">Subtotal</span><span class="price" id="final-subtotal"><i class="fa-solid fa-indian-rupee-sign"></i> {{$total}}</span></div>

                            {{-- <div class="summary-item"><span class="text">Discount</span><span class="price">$0</span></div> --}}

                            <div class="summary-item"><span class="text">Shipping <span class="text-success">(Free)</span></span><span class="price"><i class="fa-solid fa-indian-rupee-sign"></i> 0</span></div>

                            <div class="summary-item"><span class="text">Total</span><span class="price" id="final-total"><i class="fa-solid fa-indian-rupee-sign"></i> {{$total}}</span><input id="total" type="hidden" value="{{$total}}" name="total"></div>


                            <div class="d-grid mb-1 mt-4">
                                <a data-id="{{Auth::guard('customer')->user()->id}}"  href="javascript:;" style="border-radius: 0px;" class="btn btn-outline-danger btn-lg mb-1 mt-1 emptyRecord">Empty Cart</a>

                                <a href="{{route('checkout')}}" style="border-radius: 0px;" class="btn btn-warning btn-lg mt-1 mb-1">Checkout</a>
                            </div>

                            <div class="d-grid mt-4 text-center">
                                <span class="text-muted">
                                    <i class="fa-solid fa-shield"></i>&nbsp; Safe & Secure
                                </span>
                                <span class="text-muted">
                                    <i class="fa-solid fa-anchor"></i>&nbsp; 100% Buyer Protection
                                </span>
                                <span class="text-muted">
                                    <i class="fa-solid fa-rotate-left"></i>&nbsp; Easy Returns & Refunds
                                </span>
                            </div>

                            <div class="d-grid mt-4 text-center">
                                <span class="text-muted">
                                    <i class="fa-solid fa-shield"></i>&nbsp; Safe & Secure Payment
                                </span>
                                <span class="text-muted">
                                    <i class="fa-solid fa-anchor"></i>&nbsp; 100% Buyer Protection
                                </span>
                                <span class="text-muted">
                                    <i class="fa-solid fa-rotate-left"></i>&nbsp; Easy Returns & Refunds
                                </span>
                            </div>

                            <div class="d-grid mt-4 text-center">
                                <a href="{{route('product', ['value' => 'list'])}}" class="text-decoration-none">
                                    <i class="fa-solid fa-circle-arrow-left"></i>&nbsp; Continue Shopping
                                </a>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-center mt-5 align-self-end">
                                <i class="fa-brands fa-cc-mastercard fa-xl"></i>
                                <i class="fa-brands fa-cc-discover fa-xl"></i>
                                <i class="fa-brands fa-cc-jcb fa-xl"></i>
                                <i class="fa-brands fa-cc-paypal fa-xl"></i>
                                <i class="fa-brands fa-cc-stripe fa-xl"></i>
                                <i class="fa-brands fa-cc-visa fa-xl"></i>
                                <i class="fa-brands fa-cc-amazon-pay fa-xl"></i>
                                <i class="fa-brands fa-cc-amex fa-xl"></i>
                                <i class="fa-brands fa-cc-apple-pay fa-xl"></i>
                                <i class="fa-brands fa-cc-diners-club fa-xl"></i>
                            </div>

                        </div>
                    </div>

                @else

                    <div class="col-12 position-absolute top-50 start-50 translate-middle text-center empty-cart-area">

                        <div class="d-grid mt-0 mb-2 text-center">

                            <h4 class="text-danger">Empty Cart</h4>

                        </div>

                        <div class="d-grid mt-2 mb-0 text-center">
                            <a href="{{route('product', ['value' => 'list'])}}" class="text-decoration-none">
                                <i class="fa-solid fa-circle-arrow-left"></i>&nbsp; Continue Shopping
                            </a>
                        </div>

                    </div>

                @endif

            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script src="{{ asset(mix('js/store/qty.js')) }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

{{-- for update cart and subtotal and total change --}}
<script>
    $(document).on('change', '.qty', function(e) {
        e.preventDefault();

        var quantity = $(this).val();  // trasnlate: pass the value of the clicked  (target) element
        var id = $(this).attr("data-id");

        $.ajax({
            url: "{{ route('qtyUpdate') }}",
            method: "POST",
            dataType: "json",
            data: {
                _token: "{{ csrf_token() }}",
                quantity: quantity,
                id: id,
            },

            beforeSend: function () {
                $(".minus").prop("disabled", true);
                $(".plus").prop("disabled", true);
            },

            success: function (response) {
                if (response)
                {
                    $('#span-subtotal-'+id).html('<i class="fa-solid fa-indian-rupee-sign"></i> '+response);
                    $('#subtotal-'+id).val(response);

                    var sum = 0;

                    $('.sum-subtotal').each(function () {
                        sum += Number($(this).val());
                    });

                    $('#final-subtotal').html('<i class="fa-solid fa-indian-rupee-sign"></i> '+sum);
                    $('#final-total').html('<i class="fa-solid fa-indian-rupee-sign"></i> '+sum);

                    $('#total').val(sum);
                }
                else
                {
                    new PNotify({text: 'Cart Quantity Not Update !', styling: 'fontawesome', icon: 'fa-solid fa-triangle-exclamation', animateSpeed: 'fast', closer: false, delay: '3000', type: 'error'});
                }
            },

            error: function (xhr) {
                //alert(xhr.responseText);
            },

            complete: function () {
                $(".minus").prop("disabled", false);
                $(".plus").prop("disabled", false);
            },

        });

    });
</script>

{{-- for destroy item and empty cart --}}
<script>

    // for cart item delete
    $(document).on('click','.deleteRecord',function(){

        var id = $(this).data("id");
        var url1 = '{{ route("cartitemdestroy",["id" =>  ":id"]) }}';
        var finalurl1 = url1.replace(':id', id);

        var token = $("meta[name='csrf-token']").attr("content");

        var sum = 0;
        var count = 0;
        var finalcount = 0;
        var lengths = 0;

        Swal.fire({
        title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger ml-1',
                buttonsStyling: false,
                }).then(function (result) {
                    if (result.value)
                    {
                      $.ajax({
                        url: finalurl1,
                        type: 'DELETE',
                        data: {
                          "id": id,
                        },

                        'beforeSend': function (request) {
                          request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
                        },

                        success: function () {
                          $('#product-area-'+id).fadeOut(1000, function(){
                            $('#product-area-'+id).remove();

                            count = $('#count-item').text();

                            finalcount = count - 1;

                            $('#count-item').text(finalcount);
                            $('#main-cart-count').text(finalcount);

                            $('.sum-subtotal').each(function () {
                                sum += Number($(this).val());
                            });

                            $('#final-subtotal').html('<i class="fa-solid fa-indian-rupee-sign"></i> '+sum);
                            $('#final-total').html('<i class="fa-solid fa-indian-rupee-sign"></i> '+sum);

                            $('#total').val(sum);

                            lengths = $('.product-area').length;

                            if (lengths == 0)
                            {
                                $('.cart-area').remove();
                                $('#count-item').text('0');
                                $('#main-cart-count').text('0');
                                $('#main-cart-area').html(`<div class="col-12 position-absolute top-50 start-50 translate-middle text-center empty-cart-area"><div class="d-grid mt-0 mb-2 text-center"><h4 class="text-danger">Empty Cart</h4></div><div class="d-grid mt-2 mb-0 text-center"><a href="{{route('product', ['value' => 'list'])}}" class="text-decoration-none"><i class="fa-solid fa-circle-arrow-left"></i>&nbsp; Continue Shopping</a></div></div>`);
                            }
                          });

                          Swal.fire({
                            type: "success",
                            title: 'Deleted!',
                            text: 'Cart item has been deleted.',
                            confirmButtonClass: 'btn btn-success',
                          })
                        }

                      });

                    }
                })

    });


    // for whole cart items delete or empty cart
    $(document).on('click','.emptyRecord',function(){

        var id = $(this).data("id");
        var url = '{{ route("wholecartitemdestroy",["id" =>  ":id"]) }}';
        var finalurl = url.replace(':id', id);

        var token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
        title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger ml-1',
                buttonsStyling: false,
                }).then(function (result) {
                    if (result.value)
                    {
                      $.ajax({
                        url: finalurl,
                        type: 'DELETE',
                        data: {
                          "id": id,
                        },

                        'beforeSend': function (request) {
                          request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
                        },

                        success: function () {
                          $('.cart-area').fadeOut(1000, function(){
                            $('.cart-area').remove();
                            $('#count-item').text('0');
                            $('#main-cart-count').text('0');
                            $('#main-cart-area').html(`<div class="col-12 position-absolute top-50 start-50 translate-middle text-center empty-cart-area"><div class="d-grid mt-0 mb-2 text-center"><h4 class="text-danger">Empty Cart</h4></div><div class="d-grid mt-2 mb-0 text-center"><a href="{{route('product', ['value' => 'list'])}}" class="text-decoration-none"><i class="fa-solid fa-circle-arrow-left"></i>&nbsp; Continue Shopping</a></div></div>`);
                          });

                          Swal.fire({
                            type: "success",
                            title: 'Deleted!',
                            text: 'Cart is empty.',
                            confirmButtonClass: 'btn btn-success',
                          })
                        }

                      });

                    }
                })

    });

</script>

@endsection
