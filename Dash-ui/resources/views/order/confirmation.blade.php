@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')
    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Order Confirmation</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Order Confirmation Area Start ##### -->
    <section class="order-confirmation-area section-padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="order-comfirmation-heading mb-50">
                        <h3>Thank you for your order!</h3>
                        <p>Your order has been successfully placed.</p>
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="row">
                <div class="col-12">
                    <div class="order-details-confirmation">
                        <div class="cart-page-heading mb-30">
                            <h5>Order Details</h5>
                        </div>

                        <!-- Display order details here -->
                        <ul class="order-details-form mb-4">
                            <!-- Example order details (modify based on your actual data structure) -->
                            <li><span>Order ID:</span> <span>{{ $orderDetails['order_id'] ?? '' }}</span></li>
                            <li><span>Product:</span> <span>{{ $orderDetails['product_name'] ?? '' }}</span></li>
                            <li><span>Total:</span> <span>{{ $orderDetails['total'] ?? '' }}</span></li>
                            <!-- Add more details as needed -->
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Additional content or instructions can be added here -->

        </div>
    </section>
    <!-- ##### Order Confirmation Area End ##### -->
@endsection
