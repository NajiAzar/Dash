@extends('layouts.app') <!-- Use your own base template -->

@section('content')
  <!-- ##### Single Product Details Area Start ##### -->
  <section class="single_product_details_area d-flex align-items-center">
    <!-- Single Product Thumb -->
    <div class="single_product_thumb clearfix">
        @if($product->images->count() > 1)
            <div class="product_thumbnail_slides owl-carousel">
                @foreach($product->images as $image)
                    <img src="{{ url('storage/' . $image->url) }}" alt="Product Image">
                @endforeach
            </div>
        @elseif($product->images->count() === 1)
            <img src="{{ url('storage/' . $product->images->first()->url) }}" alt="Product Image">
        @else
            <img src="{{ asset('path_to_default_image.jpg') }}" alt="Default Product Image">
        @endif
    </div>

    <!-- Single Product Description -->
    <div class="single_product_desc clearfix">
        <span>{{ $product->brand->brand_name }}</span>
        <a href="{{ route('frontend.products.product_detail', ['id' => $product->id]) }}">
            <h2>{{ $product->name }}</h2>
        </a>
        <p class="product-price"><span class="old-price">${{ $product->old_price }}</span> ${{ $product->price }}</p>
        <p class="product-desc">{{ $product->description }}</p>
        @if(session('success'))
    <div class="alert alert-success" id="successMessage">
        {{ session('success') }}
    </div>
    <script>
        // Add JavaScript to hide the success message after 1seconds
        setTimeout(function () {
            document.getElementById('successMessage').style.display = 'none';
        }, 1000); // 5000 milliseconds (5 seconds)
    </script>
@endif

        <!-- Form -->
        <form class="cart-form clearfix" method="post" action="{{ route('cart.add', ['product' => $product->id]) }}">
            @csrf
            <div class="quantity-selector d-flex align-items-center mb-30">
        <!-- Quantity Selector -->
        <input type="number" value="{{ $cartItems[$product->id]->quantity ?? 1 }}" name="quantity" id="quantity" min="1">
    </div>
            <!-- Select Box for Size (if applicable) -->
            <!-- Select Box for Color (if applicable) -->
            <div class="cart-fav-box d-flex align-items-center">
                <!-- Cart -->
                <button type="submit" class="btn essence-btn" id="addToCartButton">Add to cart</button>
                <!-- Favourite -->
                <div class="product-favourite ml-4">
                    <a href="#" class="favme fa fa-heart{{ $isInWishlist ? ' active' : '' }}"
                        data-product-id="{{ $product->id }}"
                        data-wishlist-item-id="{{ $wishlistItem ? $wishlistItem->id : null }}"
                        onclick="removeOrConfirm(this)">
                    </a>
                </div>
            </div>
        </form>
  
    </div>
  </section>
  <section class="new_arrivals_area section-padding-80 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center">
                    <h2>Similar Products</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="popular-products-slides owl-carousel">
                    @foreach($similarProducts  as $similarProduct)
                        <!-- Single Product -->
                        <div class="single-product-wrapper">
                            <!-- Product Image -->
                            <div class="product-img">
                                <img src="{{ asset('storage/' . $similarProduct->images->first()->url) }}" alt="">
                                  <!-- Hover Thumb -->
            @if ($similarProduct->images->count() > 1)
                <img class="hover-img" src="{{ asset('storage/' . $similarProduct->images[1]->url) }}" alt="">
            @endif
                                
                            </div>
                            <!-- Product Description -->
                            <div class="product-description">
                                <span>{{ $similarProduct->brand_name }}</span>
                                <a href="{{ route('frontend.products.product_detail', ['id' => $similarProduct->id]) }}">
                                    <h6>{{ $similarProduct->name }}</h6>
                                </a>
                                <p class="product-price">${{ $similarProduct->price }}</p>

                                <!-- Hover Content -->
                                <div class="hover-content">
                                    <!-- Add to Cart -->
                                    <div class="add-to-cart-btn">
                                            <form action="{{ route('cart.add', ['product' => $product->id]) }}"
                                                method="post">
                                                @csrf <!-- Add the CSRF token for form security -->
                                                <button type="submit" class="btn essence-btn">Add to Cart</button>
                                            </form>
                                        </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
