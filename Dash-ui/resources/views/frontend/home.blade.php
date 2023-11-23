<!-- resources/views/frontend/home.blade.php -->
@extends('layouts.app') <!-- Use your own base template -->

@section('content')
      <!-- ##### Welcome Area Start ##### -->
      <div id="homeCarousel" class="carousel slide" data-bs-ride="carousel">
      @foreach ($homeSlides as $slide)
    <div class="carousel-inner">
       
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <div class="welcome_area bg-img background-overlay" style="background-image: url({{ asset('storage/'.$slide->image) }});">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-12">
                                <div class="hero-content">
                                    <h6>{{ $slide->description }}</h6>
                                    <h2>{{ $slide->title }}</h2>
                                    <a href="{{ $slide->target_url }}" class="btn essence-btn" style="margin-left: 13rem;">View Collection</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
     
    </div>
    @endforeach
    <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


    <!-- ##### Welcome Area End ##### -->

    <!-- ##### Top Catagory Area Start ##### -->
    <div class="top_catagory_area section-padding-80 clearfix">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($featuredCategories as $category)
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url({{ asset('storage/' . $category->image) }});">
                        <div class="catagory-content">
                            <a href="{{ route('frontend.products.index', ['category' => $category]) }}" class="text-center">{{ $category->CategoryName }}</a>
              
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

    <!-- ##### Top Catagory Area End ##### -->

    <!-- ##### CTA Area Start ##### -->
    
    <div class="cta-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div id="promotionalBannersCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($promotionalBanners as $banner)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <div class="cta-content bg-img background-overlay" style="background-image: url({{ asset('storage/'.$banner->image)  }});">
                                    <div class="h-100 d-flex align-items-center justify-content-end">
                                        <div class="cta--text">
                                            <h6>{{ $banner->description }}</h6>
                                            <h2>{{ $banner->title }}</h2>
                                            <a href="{{ $banner->target_url }}" class="btn essence-btn">Buy Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#promotionalBannersCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#promotionalBannersCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- ##### CTA Area End ##### -->

    <!-- ##### New Arrivals Area Start ##### -->
    <section class="new_arrivals_area section-padding-80 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center">
                    <h2>Popular Products</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="popular-products-slides owl-carousel">
                    @foreach($products as $product)
                        <!-- Single Product -->
                        <div class="single-product-wrapper">
                            <!-- Product Image -->
                            <div class="product-img">
                                <img src="{{ asset('storage/' . $product->images->first()->url) }}" alt="">
                                  <!-- Hover Thumb -->
            @if ($product->images->count() > 1)
                <img class="hover-img" src="{{ asset('storage/' . $product->images[1]->url) }}" alt="">
            @endif
                                
                            </div>
                            <!-- Product Description -->
                            <div class="product-description">
                                <span>{{ $product->brand_name }}</span>
                                <a href="{{ route('frontend.products.product_detail', ['id' => $product->id]) }}">
                                    <h6>{{ $product->name }}</h6>
                                </a>
                                <p class="product-price">${{ $product->price }}</p>

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

    <!-- ##### New Arrivals Area End ##### -->

  <!-- ##### Brands Area Start ##### -->

  <div id="brandCarousel" class="popular-products-slides owl-carousel brands-area d-flex align-items-center justify-content-between">
    @foreach($brandLogos as $brandLogo)
        <div class="item ">
            <!-- Brand Logo -->
            <div class="single-brands-logo">
              <a href="{{ route('frontend.products.index', [ 'brand' => $brandLogo->id,]) }}" > <img src="{{ asset('storage/'.$brandLogo->image) }}" alt="{{ $brandLogo->name }}">
</a> </div>
        </div>
    @endforeach
</div>

      

<!-- Initialize Owl Carousel -->

<!-- ##### Brands Area End ##### -->

@endsection
