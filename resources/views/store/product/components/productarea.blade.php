@foreach($data as $product)

    <div class="col">
        <div class="card shadow-lg">

            @if(isset($product->thumbnail) && !empty($product->thumbnail) && $product->thumbnail)

                @if (file_exists(public_path().'/productthumbnail/'.$product->thumbnail))

                    <img class="img-fluid bd-placeholder-img card-img-top border-bottom p-4" style="height: 225px; width: 100%;" src="{{asset('productthumbnail/'.$product->thumbnail)}}" alt="Product Thumbnail" title="Product Thumbnail" role="img" aria-label="Placeholder: Product Thumbnail">

                @else

                    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Product Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Product Thumbnail</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Product Thumbnail</text></svg>

                @endif

            @else

                <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Product Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Product Thumbnail</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Product Thumbnail</text></svg>

            @endif

            <div class="card-body">

                <h4 class="card-text pb-1">{{$product->name}}</h4>

                <h6 class="card-text text-muted pb-3">{{$product->brand}}</h6>

                <div class="d-flex justify-content-between align-items-center">

                    <a href="{{route('productdetails', ['id' => $product->id])}}" class="btn btn-sm btn-outline-secondary" title="Product Details"><i class="fa-regular fa-eye"></i>&nbsp; View</a>

                    <small class="text-muted"><i class="fa-solid fa-indian-rupee-sign"></i>&nbsp; {{$product->price}}</small>

                </div>
            </div>
        </div>
    </div>

@endforeach

<div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center mt-5">
    <center>
        {{-- {!! $data->links() !!} --}}

        <div class="btn-group">

            @if ($data->previousPageUrl() != '')

                <a class="btn btn-outline-primary pre page-link <?php if($data->previousPageUrl() == ''){ echo 'disabled'; } ?>" href="{{ $data->previousPageUrl() }}"><i class="fa-solid fa-angles-left"></i>&nbsp; Previous</a>

            @endif

            @if ($data->nextPageUrl() != '')

                <a class="btn btn-outline-primary next page-link <?php if($data->nextPageUrl() == ''){ echo 'disabled'; } ?>" href="{{ $data->nextPageUrl() }}">Next &nbsp;<i class="fa-solid fa-angles-right"></i></a>

            @endif

        </div>
    </center>
</div>
