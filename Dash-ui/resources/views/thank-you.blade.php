@extends('layouts.app')

@section('content')
<div class="single-blog-wrapper"> <!-- Single Blog Post Thumb -->
    <div class="single-blog-post-thumb"> <img src="img/bg-img/bg-8.jpg" alt=""> </div>

        <div class="container"> <div class="row justify-content-center">
            <div class="col-12 col-md-8">
            <div class="regular-page-content-wrapper section-padding-80">
            <div class="regular-page-text">
                <h2>Thank You!</h2>
                <p>Your order has been successfully processed. Thank you for shopping with us!</p>


                <h2>Order Details:</h2>

                <ul>
                    @foreach($cartItems as $cartItem)
                    <li>{{ $cartItem->product->name }} - Quantity: {{ $cartItem->quantity }}</li>
                    @endforeach
                </ul>
                <p>Total Amount: {{ $order->total }}</p>

            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection