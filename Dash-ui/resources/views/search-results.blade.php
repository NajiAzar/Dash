@extends('layouts.app') <!-- Use your own base template -->

@section('content')


<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url({{ asset('styles/img/bg-img/breadcumb.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>Search</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<!-- ##### Shop Grid Area Start ##### -->
<section class="shop_grid_area section-padding-80">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3">
                <div class="shop_sidebar_area">

                    <!-- ##### Single Widget ##### -->
                    <div class="widget catagory mb-50">
                        <!-- Widget Title -->
                        <h6 class="widget-title mb-30">Catagories</h6>

                        <!--  Catagories  -->
                        <div class="catagories sub-menu">

                            <ul class="menu ">
                                <!-- Single Item -->
                                @if($categories)
                                @foreach($categories as $category)

                                <li><a href="{{ route('frontend.products.index',['category' => $category]) }}"
                                        style="color:black !important" ;>{{ $category->CategoryName }}</a></li>

                                @endforeach
                                @endif

                                <!-- Single Item -->

                                <!-- Single Item -->
                            </ul>
                        </div>



                    </div>

                    <!-- ##### Single Widget ##### -->

                    <div class="widget price mb-50">
                        <!-- Widget Title -->
                        <h6 class="widget-title mb-30">Filter by</h6>
                        <!-- Widget Title 2 -->
                        <p class="widget-title2 mb-30">Price</p>

                        <div class="widget-desc">
                            <div class="slider-range">
                                <div data-min="49" data-max="360" data-unit="$"
                                    class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                                    data-value-min="49" data-value-max="360" data-label-result="Range:">
                                    <div class="ui-slider-range ui-widget-header ui-corner-all"></div>

                                    <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                    <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                </div>
                                <div class="range-price">Range: $49.00 - $360.00</div>
                            </div>
                        </div>
                    </div>

                    <!-- ##### Single Widget ##### -->

                    <!-- ##### Single Widget ##### -->
                    <div class="widget brands mb-50">
                        <!-- Widget Title 2 -->
                        <p class="widget-title2 mb-30">Brands</p>
                        <div class="widget-desc">
                            <ul>
                                @foreach($brands as $brand)
                                <li><a
                                        href="{{ route('frontend.products.index', ['category' => $category, 'brand' => $brand->id, 'sort' => $selectedSortOption]) }}">{{
                                        $brand->brand_name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12 col-md-8 col-lg-9">
                <div class="shop_grid_product_area">
                    <div class="row">
                        <div class="col-12">
                            <div class="product-topbar d-flex align-items-center justify-content-between">
                                <!-- Total Products -->
                                <div class="total-products">
                                    <p><span>{{ $productCount }}</span> products found</p>
                                </div>
                                <!-- <div class="">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="sortByDropdown" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Sort by
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="sortByDropdown">
                                            <a class="dropdown-item" href="#" data-sort-option="newest">Newest</a>
                                            <a class="dropdown-item" href="#" data-sort-option="price_low_high">Price:
                                                Low to High</a>
                                            <a class="dropdown-item" href="#" data-sort-option="price_high_low">Price:
                                                High to Low</a>
                                        </div>
                                    </div>
                                </div> -->



                            </div>
                        </div>
                    </div>

                    <div class="row" id="products-container">

                        @foreach($products as $product)
                        <!-- Single Product -->
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-product-wrapper">
                                <!-- Display the first product image -->
                                @if($product->images->isNotEmpty())
                                <div class="product-images">
                                    <img src="{{ asset('storage/' . $product->images->first()->url) }}"
                                        alt="Product Image">
                                </div>
                                @endif
                                <!-- Product Description -->
                                <div class="product-description">
                                    <span>{{ $product->brand->brand_name }}</span>
                                    <a href="{{ route('frontend.products.product_detail', ['id' => $product->id]) }}">
                                        <h6>{{ $product->name }}</h6>
                                    </a>
                                    <p class="product-price">₹{{ $product->price }}</p>
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
                        </div>

                        @endforeach
                    </div>

                </div>
                <!-- Pagination -->
              
            </div>
        </div>
    </div>
</section>
<!-- ##### Shop Grid Area End ##### -->

@endsection
@section('footer_script')
<script>
    $(document).ready(function () {
        $('.product_thumbnail_slides').owlCarousel({
            items: 1,
            loop: true,
            nav: true,
            navText: [
                "<span class='nav-arrow prev-arrow'></span>",
                "<span class='nav-arrow next-arrow'></span>"
            ],
            autoplay: true,
            autoplayTimeout: 3000
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.dropdown-item').on('click', function (e) {
            e.preventDefault();

            var selectedSortOption = $(this).data('sort-option');
            var categoryId = getCategoryFromURL();
            var brandId = getBrandFromURL();
            var baseUrl = "{{ route('frontend.products.index') }}";

            // Build the dynamic URL with selected options
            var dynamicUrl = baseUrl + '?' +
                'category=' + categoryId +
                '&brand=' + brandId +
                '&sort=' + selectedSortOption;

            // Redirect to the dynamic URL
            window.location.href = dynamicUrl;
        });

        function getCategoryFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('category');
        }

        function getBrandFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('brand');
        }
    });
</script>
<script>
    // Get the modal and button elements
    var modal = document.getElementById("login-modal");
    var loginBtn = document.getElementById("login-btn");
    var closeBtn = document.getElementById("close-modal");
    var createAccountBtn = document.getElementById("create-account-btn");

    // Show the modal when the user clicks on the login button
    loginBtn.onclick = function () {
        modal.style.display = "block";
    }

    // Close the modal when the user clicks the close button
    closeBtn.onclick = function () {
        modal.style.display = "none";
    }

    // Handle the "Create Your Account" button click event
    createAccountBtn.onclick = function () {
        // Navigate to the registration page
        window.location.href = "/register"; // Replace with the actual URL of your registration page route
    }

</script>



@endsection