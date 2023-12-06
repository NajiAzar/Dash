@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')
<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>Checkout</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<!-- ##### Checkout Area Start ##### -->
<div class="checkout_area section-padding-80">
    <div class="container">
        <div class="row">

            <div class="col-12 col-md-6">
                <div class="checkout_details_area mt-50 clearfix">

                    <div class="cart-page-heading mb-30">
                        <h5>Billing Address</h5>
                    </div>
                    <!-- Display validation errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form action="{{ route('checkout.process') }}" method="post">
                            @csrf                    
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name">First Name <span>*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name">Last Name <span>*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="" required>
                                </div>
            
                                <div class="col-12 mb-3">
                                    <label for="address">Address <span>*</span></label>
                                    <input type="text" class="form-control mb-3" id="address" name="address" value="">
                                  
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="postcode">Postcode <span>*</span></label>
                                    <input type="text" class="form-control" id="postcode" name="postcode" value="">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="city">Town/City <span>*</span></label>
                                    <input type="text" class="form-control" id="city" name="city" value="">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="state">State <span>*</span></label>
                                    <input type="text" class="form-control" id="state" name="state" value="">
                                </div>
                                <div class="col-12 mb-3">
                                <label for="phone_number">Phone Number<span>*</span></label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="">
                            </div>
                                <div class="col-12 mb-4">
                                    <label for="email_address">Email Address <span>*</span></label>
                                    <input type="email" class="form-control" id="email_address" name="email_address" value="">
                                </div>

                                <div class="col-12">
                                    <div class="custom-control custom-checkbox d-block mb-2">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Terms and conitions</label>
                                    </div>
                               
                                    <div class="custom-control custom-checkbox d-block">
                                        <input type="checkbox"  name="same_as_billing" id="customCheck3">
                                     
                                        <label class="custom-control-label" for="customCheck3">Same as billing address</label>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
                    <div class="order-details-confirmation">

                        <div class="cart-page-heading">
                            <h5>Your Order</h5>
                            <p>The Details</p>
                        </div>

                        <ul class="order-details-form mb-4">
    @foreach($cartItems as $cartItem)
        <li>
            <span>{{ $cartItem->product->name }} ({{ $cartItem->quantity }})</span>
            <span>{{ $cartItem->product->price * $cartItem->quantity }}</span>
        </li>
    @endforeach
    <li>
        <span>Subtotal</span>
        <span id="subtotal">
        ₹ {{ collect($cartItems)->sum(function($item) { return $item->product->price * $item->quantity; }) }}
        </span>
    </li>
    <li><span>Shipping</span> <span>Free</span></li>
    <li>
        <span>Total</span>
        <span id="total">
        ₹ {{ collect($cartItems)->sum(function($item) { return $item->product->price * $item->quantity; }) }}
        </span>
    </li>
</ul>


<div class="col-12 mb-3">
<div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="razorpay" required>
            <label class="form-check-label" for="razorpay">Razorpay</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" id="cash_on_delivery" value="cash_on_delivery" required>
            <label class="form-check-label" for="cash_on_delivery">Cash on Delivery</label>
        </div>

       
</div>
                </div>
            </div>

         <div class="row mt-4">
            <div class="col-12">
                <div class="checkout_details_area mt-50 clearfix">

                    <div class="cart-page-heading mb-30">
                        <h5>Shipping Address</h5>
                    </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="shipping_address">Shipping Address <span>*</span></label>
                                <input type="text" class="form-control mb-3" id="shipping_address" name="shipping_address" value="">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="shipping_postcode">Shipping Postcode <span>*</span></label>
                                <input type="text" class="form-control" id="shipping_postcode" name="shipping_postcode" value="">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="shipping_city">Shipping Town/City <span>*</span></label>
                                <input type="text" class="form-control" id="shipping_city" name="shipping_city" value="">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="shipping_state">Shipping State<span>*</span></label>
                                <input type="text" class="form-control" id="shipping_state" name="shipping_state" value="">
                            </div>


                        </div>
                        <button type="submit" class="btn essence-btn">Place Order</button>
                    </form>
                    <script>
    // Show/hide additional fields based on the selected payment method
    document.addEventListener("DOMContentLoaded", function () {
        var paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
        var paypalFields = document.getElementById('paypal_fields');

        paymentMethodRadios.forEach(function (radio) {
            radio.addEventListener("change", function () {
                if (radio.value === 'paypal') {
                    paypalFields.style.display = 'block';
                } else {
                    paypalFields.style.display = 'none';
                }
            });
        });
    });
</script>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        var billingAddressFields = [
            "first_name",
            "last_name",
            "address",
            "postcode",
            "city",
            "state",
            "phone_number",
            "email_address"
        ];

        var shippingAddressFields = [
            "shipping_address",
            "shipping_postcode",
            "shipping_city",
            "shipping_state"
        ];

        var checkbox = document.getElementById("customCheck3");

        checkbox.addEventListener("change", function () {
            if (this.checked) {
                // Copy values from billing address to shipping address
                billingAddressFields.forEach(function (field) {
                    var billingValue = document.getElementById(field).value;
                    var shippingField = document.getElementById("shipping_" + field);
                    if (shippingField) {
                        shippingField.value = billingValue;
                    }
                });
            } else {
                // Clear values in shipping address
                shippingAddressFields.forEach(function (field) {
                    var shippingField = document.getElementById(field);
                    if (shippingField) {
                        shippingField.value = "";
                    }
                });
            }
        });

        // Form validation on submit
        var form = document.querySelector('form');
        form.addEventListener('submit', function (event) {
            if (!validateForm()) {
                event.preventDefault(); // Prevent form submission if validation fails
                alert('Please fill in all required fields.');
            }
        });

        function validateForm() {
            var isValid = true;

            billingAddressFields.forEach(function (field) {
                var input = document.getElementById(field);
                if (input && input.value.trim() === "") {
                    isValid = false;
                }
            });

            shippingAddressFields.forEach(function (field) {
                var input = document.getElementById("shipping_" + field);
                if (input && input.value.trim() === "") {
                    isValid = false;
                }
            });

            return isValid;
        }
    });
</script>
    @endsection
    <!-- ##### Checkout Area End ##### -->