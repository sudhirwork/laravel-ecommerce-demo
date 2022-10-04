@extends('layouts/store/contentLayoutMaster')

@section('title', 'Products')

@section('style')

@endsection

@section('content')

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 mt-3 mb-5 ps-1 pe-1">
        <div class="col">
            <h4>Category: <span class="text-muted"><strong>{{$category}}</strong></span></h4>
        </div>

        <div class="col">
            <input type="hidden" id="value" name="value" value="{{$value}}">
            <input type="hidden" name="hidden_page" id="hidden_page" value="1" />

            <select name="price" id="price" class="form-select">
                <option value="" selected disabled>⇅ Price Filter</option>
                <option value="">☰ All</option>
                <optgroup label="Price filter">
                    <option value="desc">▲ High to low</option>
                    <option value="asc">▼ Low to high</option>
                </optgroup>
            </select>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-4 row-cols-md-6 row-cols-lg-6 g-3" id="product_data">

        @include('store/product/components/productarea')

    </div>

<style>
    .pre{
        padding-top: 6px;
        padding-bottom: 6px;
        padding-right: 10px;
        padding-left: 10px;
        margin-right: 0px;
        border: 1px solid #7367F0;
        border-radius: 5px 0px 0px 5px;
        color: #7367F0;
        background: transparent;
    }

    .pre:hover{
        padding-top: 6px;
        padding-bottom: 6px;
        padding-right: 10px;
        padding-left: 10px;
        margin-right: 0px;
        border: 1px solid #7367F0;
        border-radius: 5px 0px 0px 5px;
        color: #ffffff;
        background-color: #7367F0;
    }

    .next{
        padding-top: 6px;
        padding-bottom: 6px;
        padding-right: 10px;
        padding-left: 10px;
        margin-left: -1px;
        border: 1px solid #7367F0;
        border-radius: 0px 5px 5px 0px;
        color: #7367F0;
        background: transparent;
    }

    .next:hover{
        padding-top: 6px;
        padding-bottom: 6px;
        padding-right: 10px;
        padding-left: 10px;
        margin-left: -1px;
        border: 1px solid #7367F0;
        border-radius: 0px 5px 5px 0px;
        color: #ffffff;
        background-color: #7367F0;
    }
</style>

@endsection

@section('script')

<script>
    $(document).ready(function(){

        $(document).on('change', '#price', function(){
            var price = $(this).val();
            var page = $('#hidden_page').val();
            fetch_data(page, price);
        });

        $(document).on('click', '.page-link', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var price = $('#price').val();
            fetch_data(page, price);
        });

        function fetch_data(page, price)
        {
            var value = $("#value").val();
            var url = '{{ route("getProduct",["value" =>  ":value"]) }}';
            var finalurl = url.replace(':value', value);

            var _token = "{{ csrf_token() }}";

            $.ajax({
                url:finalurl, // +'?page='+page+'&price='+price
                method:"POST",

                data:{
                    _token:_token,
                    page:page,
                    price:price
                },

                success:function(data)
                {
                    $('#product_data').html('');
                    $('#product_data').html(data);
                }
            });
        }

    });
</script>

@endsection
