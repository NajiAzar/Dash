<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Essence - Fashion Ecommerce Template</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="{{ asset('styles/img/core-img/favicon.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<!-- Core Style CSS -->
<link rel="stylesheet" href="{{ asset('styles/css/core-style.css') }}">
<link rel="stylesheet" href="{{ asset('styles/style.css') }}">

</head>
<style>
    .nav-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: #fff;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .nav-arrow:hover {
        opacity: 1;
    }

    .prev-arrow {
        left: -10px;
        background: url('{{ asset('styles/img/core-img/long-arrow-left.svg') }}') no-repeat center center;
    }

    .next-arrow {
        right: -10px;
        background: url('{{ asset('styles/img/core-img/long-arrow-right.svg') }}') no-repeat center center;
    }
    /* Style for the modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
    position: relative;
}

.close {
    position: absolute;
    right: 10px;
    top: 10px;
    font-size: 20px;
    cursor: pointer;
}
#cancelLink:hover {
        color: blue !important;
    }

    #cancelLink {
        color: red;
        text-decoration: none;
    }



</style>

<body>
<header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="index.html"><img src="{{ asset('styles/img/core-img/logo.png') }}" alt=""></a>
                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
                <!-- Menu -->
                <div class="classy-menu">
                    <!-- close btn -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <div class="classynav">
                         <ul>
                         <li><a href="#">Categories</a>
            <div class="megamenu">
                @if($categories)
                    @foreach($categories as $category)
                     
                        @if($category->subcategories)
                            <ul class="single-mega cn-col-4">
                                <li class="title">  <a href="{{ route('frontend.products.index', ['category' => $category->id]) }}">{{ $category->CategoryName }}</a></li>
                                @foreach($category->subcategories as $subcategory)
                                     
                                        <ul>
                                        <a href="{{ route('frontend.products.index',  ['category' => $subcategory->id]) }}">{{ $subcategory->CategoryName }}</a>
                                        </ul>
                                     
                                @endforeach
                            </ul>
                        @endif
                    @endforeach
                @endif
                <div class="single-mega cn-col-4">
                    <img src="{{ asset('styles/img/bg-img/bg-6.jpg') }}" alt="">
                </div>
            </div>
        </li>
        
        <li><a href="blog.html">Blog</a></li>
                            <li><a href="contact.html">Contact</a></li>
    </ul>
</div>
<!-- Nav End -->

                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <!-- Search Area -->
                <div class="search-area">
                <form id="trackOrderForm" action="{{ route('trackOrder') }}" method="get">
        @csrf
        <input type="text" name="order_number" id="orderNumber" placeholder="Trackorder" required>
        <button type="button" id="trackOrderButton"></button>
    </form>
</div>
<div class="search-area">
    <form action="{{ route('search') }}" method="get">
        @csrf
        <input type="search" name="query" id="headerSearch" placeholder="Type for search">
        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
</div>

                <!-- Favourite Area -->
                <div class="favourite-area">
                    <a href="{{ route('wishlist.index') }}"><img src="{{ asset('styles/img/core-img/heart.svg') }}" alt=""> <span>{{ $wishlistCount }}</span></a>
                </div>
                <!-- User Login Info -->
                <div class="user-login-info">
    <a href="{{ route('login.customer') }}" ><img src="http://127.0.0.1:8000/styles/img/core-img/user.svg" alt=""></a>
</div>



                <!-- Cart Area -->
                <div class="cart-area"> 
                <a href="#" id="essenceCartBtn">
    <img src="{{ asset('styles/img/core-img/bag.svg') }}" alt="">
    <span >{{ $cartCount }}</span>
</a>
                </div>
            </div>

        </div>
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    <script>
        // Add a script to hide the alert after 2000 milliseconds (2 seconds)
        setTimeout(function() {
            document.querySelector('.alert').style.display = 'none';
        }, 2000);
    </script>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    </header>
    <!-- ##### Header Area End ##### -->

     <!-- ##### Right Side Cart Area ##### -->
     <div class="cart-bg-overlay"></div>

   <div class="right-side-cart-area">
    <!-- Cart Button -->
    <div class="cart-button">
        <a href="#" id="rightSideCart"><img src="{{ asset('styles/img/core-img/bag.svg') }}" alt=""> <span id="cartcount"></span></a>
    </div>
    <div class="cart-content d-flex">
        <!-- Cart List Area -->
        <div class="cart-list">
    @foreach($cartItems as $cartItem)
        @if ($cartItem->product) <!-- Check if the product is not null -->
            <!-- Single Cart Item -->
            <div class="single-cart-item">
                <a href="#" class="product-image">
                    @if ($cartItem->product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $cartItem->product->images->first()->url) }}" class="cart-thumb" alt="Product Image">
                    @else
                        <!-- Provide a default image or handle the case where there are no images -->
                        <img src="{{ asset('path_to_default_image.jpg') }}" class="cart-thumb" alt="Default Image">
                    @endif
                    <!-- Cart Item Desc -->
                    <div class="cart-item-desc">
                        <span class="product-remove">
                            <i class="fa fa-close remove-from-cart" data-product-id="{{ $cartItem->product->id }}" aria-hidden="true"></i>
                        </span>
                        <span class="badge">{{ $cartItem->product->brand->brand_name }}</span>
                        <h6>{{ $cartItem->product->name }}</h6>
                        <div class="quantity-selector">
                         
                        <input type="number" class="quantity-input" value="{{ $cartItem->quantity }}" data-product-id="{{ $cartItem->product->id }}" 
    data-cart-item-id="{{ $cartItem->id ?? '' }}" 
    style="width: 32px; padding-left: 2px;" data-product-price="{{ $cartItem->product->price }}">


                        </div>
                        <p class="price">₹ {{ $cartItem->product->price }}</p>
                    </div>
                </a>
            </div>
        @else
            <!-- Handle the case where the product is not found -->
            <div class="single-cart-item">
                <p>Product not found</p>
            </div>
        @endif
    @endforeach
</div>



     <!-- Cart Summary -->
<div class="cart-amount-summary" data-cart-total="{{ $cartTotal }}">
    <h2>Summary</h2>
    <!-- Display cart total -->
    <ul class="summary-table">
        <li><span>subtotal:</span> <span id="subtotal">₹ {{ $cartTotal }}</span></li>
        <li><span>delivery:</span> <span>Free</span></li>
        <li><span>total:</span> <span id="total">₹ {{ $cartTotal }}</span></li>
    </ul>
    <div class="checkout-btn mt-100">
        <a href="{{ route('checkout') }}" class="btn essence-btn">check out</a>
    </div>
</div>
    </div>
</div>



<!-- ##### Right Side Cart End ##### -->
    @yield('content')
  
  <!-- ##### Footer Area Start ##### -->
  <footer class="footer_area clearfix">
        <div class="container">
            <div class="row">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area d-flex mb-30">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="#"><img src="{{ asset('styles/img/core-img/logo2.png') }}" alt=""></a>
                        </div>
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <ul>
                                <li><a href="shop.html">Shop</a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area mb-30">
                        <ul class="footer_widget_menu">
                            <li><a href="#">Order Status</a></li>
                            <li><a href="#">Payment Options</a></li>
                            <li><a href="#">Shipping and Delivery</a></li>
                            <li><a href="#">Guides</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Use</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row align-items-end">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_heading mb-30">
                            <h6>Subscribe</h6>
                        </div>
                        <div class="subscribtion_form">
                            <form action="#" method="post">
                                <input type="email" name="mail" class="mail" placeholder="Your email here">
                                <button type="submit" class="submit"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_social_area">
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>

<div class="row mt-5">
                <div class="col-md-12 text-center">
                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>, distributed by <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>

        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

<!-- Owl Carousel CSS -->


<!-- Owl Carousel JS -->


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('styles/js/jquery/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('styles/js/popper.min.js') }}"></script>
    <script src="{{ asset('styles/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('styles/js/plugins.js') }}"></script>
    <script src="{{ asset('styles/js/classy-nav.min.js') }}"></script>
    <script src="{{ asset('styles/js/active.js') }}"></script>

 @yield('footer_script')

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js">
    
</script> <!-- Include jQuery library if not already included -->
<script>
$(document).ready(function() {
    $('.remove-from-cart').on('click', function() {
        var productId = $(this).data('product-id');
        var cartItem = $(this).closest('.single-cart-item');

        $.ajax({
            url: '{{ route('cart.remove', ['product_id' => 'REPLACE_WITH_PRODUCT_ID']) }}'.replace('REPLACE_WITH_PRODUCT_ID', productId),
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.newCartCount !== undefined) {
                    // Update the cart count on the page
                    const cartCountElement = document.getElementById('cartcount');
                    if (cartCountElement) {
                        cartCountElement.textContent = response.newCartCount;
                    }
                }

                cartItem.hide();

                // Assuming the key for newCartTotal in your response is 'newCartTotal'
                updateCartSummary(response.newCartTotal);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    function updateCartSummary(newCartTotal) {
    console.log('Function called');

    const subtotalElement = document.getElementById('subtotal');
    const totalElement = document.getElementById('total');

    console.log(newCartTotal, subtotalElement.text(), totalElement.text());

    if (subtotalElement && totalElement) {
        subtotalElement.textContent = '₹ ' + newCartTotal.toFixed(2);
        totalElement.textContent = '₹ ' + newCartTotal.toFixed(2);
    }
}

});

</script>

<script>

function removeOrConfirm(heartIcon) {
        var productId = $(heartIcon).data('product-id');
        var wishlistItemId = $(heartIcon).data('wishlist-item-id');

        if (wishlistItemId) {
    // The product is in the wishlist, ask for confirmation
    if (confirm("Are you sure you want to remove this product from your wishlist?") == false) {
        location.reload();
        // User clicked "Cancel," do nothing
    } else {
        // User clicked "OK," remove from the wishlist
        removeFromWishlist(wishlistItemId);
    }
} else {
    // The product is not in the wishlist, add it
    addToWishlist(productId);
}
    }

    function addToWishlist(productId) {
            // You can use AJAX to add the product to the wishlist here
            $.ajax({
                type: 'POST',
                url: '{{ route('wishlist.add', ['product' => '__product_id__']) }}'.replace('__product_id__', productId),
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        // The product was added to the wishlist successfully
                        // You can update the heart icon to indicate that it's in the wishlist.
                        // For example, change the icon color or add a checkmark.
                        // You can also update the UI as needed.
                        //$('.favme.active').addClass('in-wishlist');
                        location.reload();
                    } else {
                        alert('Failed to add the product to your wishlist.');
                    }
                }
            });
        }


        function removeFromWishlist(wishlistItemId) {
    // You can use AJAX to remove the product from the wishlist here
    $.ajax({
        type: 'DELETE',
        url: '{{ route('wishlist.remove', ['wishlist' => '__wishlist_id__']) }}'.replace('__wishlist_id__', wishlistItemId),
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            if (response.success) {
                // The product was removed from the wishlist successfully
                // You can update the heart icon to indicate that it's not in the wishlist.
                // For example, remove the "active" class or change the icon color.
                // You can also update the UI as needed.
                $('.favme.active').removeClass('active').removeClass('in-wishlist');

                // Reload the page to reflect the updated wishlist status
                location.reload();
            } else {

                alert('Failed to remove the product from your wishlist.');
                
            }
        }
    });
}

</script>








<!-- JavaScript for Quantity Selector -->

<!-- JavaScript for Quantity Selector -->

<script>
  // JavaScript for updating cart summary based on quantity changes
document.addEventListener('input', function (event) {
    if (event.target.classList.contains('quantity-input')) {
        updateSummary(event.target);
        updateCart(event.target);
    }
});

function updateCart(input) {
    const productId = input.getAttribute('data-product-id');
    const cartItemId = input.getAttribute('data-cart-item-id');
    const newQuantity = input.value;

    // Check if the user is logged in
    const isLoggedIn = '{{ auth()->guard('customer')->check() }}';

    if (isLoggedIn) {
        // User is logged in, send an AJAX request to update the cart in the database
        $.ajax({
            type: 'POST',
            url: '{{ route('cart.updateQuantity') }}', // Use the correct route name
            data: {
                '_token': '{{ csrf_token() }}',
                'product_id': productId,
                'cart_item_id': cartItemId,
                'new_quantity': newQuantity
            },
            success: function (response) {
                if (response.success) {
                    // The cart was updated successfully
                    // You can choose to update the cart totals or other UI elements as needed
                    // For example, call a function to recalculate the cart summary
                    //alert("responsejhbsuccess");
                    updateSummary();
                } else {
                    alert('Failed to update the cart quantity.');
                }
            },
            error: function (xhr, status, error) {
                console.error(error); // Log the error to the console
                // Optionally, display an error message to the user
            }
        });
    } else {
        // User is not logged in, update the session cart using another route
        $.ajax({
            type: 'POST',
            url: '{{ route('cart.updateQuantityLoggedOut') }}', // Use the correct route name for updating session cart
            data: {
                '_token': '{{ csrf_token() }}',
                'product_id': productId,
                'cart_item_id': cartItemId,
                'new_quantity': newQuantity
            },
            success: function (response) {
                if (response.success) {
                    // The session cart was updated successfully
                    // You can choose to update the UI elements as needed
                    // For example, call a function to recalculate the cart summary
                   // alert(response.success);
                    updateSummary();
                } else {
                    alert('Failed to update the cart quantity.');
                }
            },
            error: function (xhr, status, error) {
                console.error(error); // Log the error to the console
                // Optionally, display an error message to the user
            }
        });
    }
}




function updateSummary(input) {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const subtotalElement = document.getElementById('subtotal');
    const totalElement = document.getElementById('total');
    let newSubtotal = 0;

    quantityInputs.forEach(inputField => { 
        const productPrice = parseFloat(inputField.getAttribute('data-product-price'));
        const quantity = parseInt(inputField.value, 10);
     //  alert(productPrice);
        if (!isNaN(productPrice) && !isNaN(quantity)) {
            newSubtotal += productPrice * quantity;

        }
       // alert(newSubtotal);

    });

    if (subtotalElement && totalElement) {
        subtotalElement.textContent = '₹ ' + newSubtotal.toFixed(2);
        totalElement.textContent = '₹ ' + newSubtotal.toFixed(2);
    }
}


</script>
<script>
    $(document).ready(function () {
        $('#trackOrderButton').click(function () {
            var orderNumber = $('#orderNumber').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('trackOrder') }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'order_number': orderNumber
                },
                success: function (data) {
                    // Handle the successful response here
                    console.log(data);
                },
                error: function (error) {
                    // Handle errors here
                    console.log(error);
                }
            });
        });
    });
</script>
<script>
    // Auto-dismiss alert messages after 3 seconds
    setTimeout(function() {
        document.getElementById('success-alert').style.display = 'none';
        document.getElementById('error-alert').style.display = 'none';
    }, 3000);
</script>



</body>

</html>
