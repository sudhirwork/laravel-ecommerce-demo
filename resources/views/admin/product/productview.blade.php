@extends('layouts/admin/contentLayoutMaster')

@section('title', 'View Product')

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

    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-header">
                <h4 class="pt-2">Product Details</h4>
            </div>
            <div class="card-body">

                <ul class="list-group">

                    @if(isset($product->thumbnail) && !empty($product->thumbnail) && $product->thumbnail)

                        @if (file_exists(public_path().'/productthumbnail/'.$product->thumbnail))

                            <li class="list-group-item"><strong>Product Thumbnail: </strong><div><img class="rounded-3 img-fluid" style="height:50px; width:50px;" src="{{asset('productthumbnail/'.$product->thumbnail)}}" alt="thumbnail"></div></li>

                        @endif

                    @endif

                    <li class="list-group-item"><strong>Category Name: </strong><span class="badge rounded-pill text-bg-primary"><?php echo $category->name; ?></span></li>

                    <li class="list-group-item"><strong>Product Name: </strong><?php echo $product->name; ?></li>

                    <li class="list-group-item"><strong>Product Brand: </strong><?php echo $product->brand; ?></li>

                    <li class="list-group-item"><strong>Product Code: </strong><span class="badge rounded-pill text-bg-warning"><?php echo $product->code; ?></span></li>

                    <li class="list-group-item"><strong>Product Stock Quantity: </strong><?php echo $product->stock_quantity; ?></li>

                    <li class="list-group-item"><strong>Product Price: </strong><span class="badge rounded-pill text-bg-success"><i class="fa-solid fa-indian-rupee-sign"></i>&nbsp;<?php echo $product->price; ?></span></li>

                </ul>

            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h4 class="pt-2">Product Description</h4>
            </div>
            <div class="card-body">

                <p>

                    <?php echo $product->description; ?>

                </p>

            </div>
        </div>
    </div>

    @if (!empty($productimages->toArray()))

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="pt-2">Product Images</h4>
                </div>
                <div class="card-body">

                    <div class="row">

                        @foreach ($productimages as $productimage)

                            <div class="col-2">

                                <img class="rounded-3 img-fluid" style="height:100px; width:100px;" src="{{asset('productimages/'.$productimage->image)}}" alt="image">

                            </div>

                        @endforeach

                    </div>

                </div>
            </div>
        </div>

    @endif

</div>

@endsection
