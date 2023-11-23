@extends('layouts.head')

@section('content')
<div class="container">
    <h2>{{ $product->name }}</h2>

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="max-width: 300px;">
        <ol class="carousel-indicators">
            @foreach ($product->images as $key => $image)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach ($product->images as $key => $image)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img class="d-block w-100" src="{{ asset('storage/' . $image->url) }}" alt="Image" style="max-width: 300px; max-height: 300px;">
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <p><strong>Price:</strong> ₹{{ $product->price }}</p>
    <p><strong>Description:</strong> {{ $product->description }}</p>
    <p><strong>Category:</strong> {{ $product->category->CategoryName }}</p>
    <p><strong>Brand:</strong> {{ $product->brand->brand_name }}</p>

    <a href="{{ route('products.show') }}" class="btn btn-primary">Back to Products</a>
</div>

<script>
    // Initialize the carousel
    $(document).ready(function() {
        $('#carouselExampleIndicators').carousel();
    });
</script>
@endsection
