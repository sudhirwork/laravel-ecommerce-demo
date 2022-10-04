@extends('layouts/store/contentLayoutMaster')

@section('title', 'Home')

@section('style')

@endsection

@section('content')

    <div class="col-12 border-bottom pt-2 pb-2 mb-4">
        <h2 class="text-muted">Latest Products</h2>
    </div>

    <div id="carouselExampleControls" class="carousel carousel-dark slide" data-bs-ride="carousel">

        <div class="carousel-inner">

            @foreach ($products as $product)

                <div class="carousel-item <?php if($product1->id == $product->id){ echo 'active'; } ?>">

                    <div class="col-12">

                        <div class="card">
                            <div class="row g-0">

                                <div class="col-md-4 ps-5 pe-5 pt-2 pb-2 border-end text-center">
                                    <img class="img-fluid rounded-3 bd-placeholder-img" style="height: 160px; width: 160px;" src="{{asset('productthumbnail/'.$product->thumbnail)}}" alt="Product Thumbnail" title="Product Thumbnail" role="img" aria-label="Placeholder: Product Thumbnail">
                                </div>

                                <div class="col-md-8">
                                    <div class="card-body">


                                        <h4 class="card-title pb-1">{{$product->name}}</h4>

                                        <h6 class="card-text text-muted">{{$product->brand}}</h6>

                                        <small class="text-muted"><i class="fa-solid fa-indian-rupee-sign"></i>&nbsp; {{$product->price}}</small>

                                        <br><br>

                                        <a href="{{route('productdetails', ['id' => $product->id])}}" class="btn btn-sm btn-outline-secondary" title="Product Details"><i class="fa-regular fa-eye"></i>&nbsp; View</a>


                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </div>

@endsection

@section('script')

@endsection
