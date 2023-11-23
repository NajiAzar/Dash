@extends('layouts.app')

@section('content')
<style>
    .gradient-custom {

        background: #cd9cf2;

        background: -webkit-linear-gradient(to top left, rgba(205, 156, 242, 1), rgba(246, 243, 255, 1));

        background: linear-gradient(to top left, rgba(205, 156, 242, 1), rgba(246, 243, 255, 1))
    }
</style>
<section class="h-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-10 col-xl-8">
                <div class="card" style="border-radius: 10px;">
                    <div class="card-header px-4 py-5">
                        <h5 class="text-muted mb-0">Thanks for your Order, <span style="color: #a8729a;">
                                {{ optional($order->customer)->name ?? 'Customer' }} </span>!!</h5>
                        <h5 class="text-muted mb-0">Your Order Details :</h5>
                    </div>
                    <div class="card-body p-4">
                        @if($order)
                        @foreach($order->orderDetails as $detail)
                        <div class="card shadow-0 border mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="{{ asset('storage/' . $detail->product->images->first()->url) }}"
                                            class="img-fluid" alt="{{ $detail->product->name }}">
                                    </div>
                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0">{{ $detail->product->name }}</p>
                                    </div>
                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0 small">{{ $detail->product->color }}</p>
                                    </div>

                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0 small">Qty: {{ $detail->quantity }}</p>
                                    </div>
                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                        <p class="text-muted mb-0 small">₹{{ $detail->product->price }}</p>
                                    </div>
                                </div>
                                <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">

                            </div>
                        </div>
                        @endforeach
                        <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                        <div class="row d-flex align-items-center">
    <div class="col-md-2">
        <p class="text-muted mb-0 small">Track Order</p>
    </div>
    <div class="col-md-10">
        @if($order->status == 'cancelled')
            <p class="text-muted mt-1 mb-0 small ms-xl-5">You have cancelled this order</p>
        @else
            <div class="progress" style="height: 6px; border-radius: 16px;">
                <div id="progressBar_{{ $order->id }}" class="progress-bar" role="progressbar"
                    style="width: 
                    @if($order->status == 'pending' || $order->status == 0)
                        25%
                    @elseif($order->status == 'processed')
                        50%
                    @elseif($order->status == 'shipped')
                        75%
                    @elseif($order->status == 'delivered')
                        100%
                    @endif
                    ; border-radius: 16px; background-color: #a8729a;" aria-valuenow="{{ $order->status }}" aria-valuemin="0"
                    aria-valuemax="100">
                </div>
            </div>
            <div class="d-flex justify-content-around mb-1">
                <p class="text-muted mt-1 mb-0 small ms-xl-5">Pending </p>
                <p class="text-muted mt-1 mb-0 small ms-xl-5">Processed</p>
                <p class="text-muted mt-1 mb-0 small ms-xl-5">Shipped</p>
                <p class="text-muted mt-1 mb-0 small ms-xl-5">Delivered</p>
            </div>
        @endif
    </div>
</div>

                        <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                        @if( auth()->guard('customer')->check() && $order->customers_id == auth()->guard('customer')->user()->id && $order->status != 'delivered')
                        @if($order->status != 'cancelled')
    <form method="post" action="{{ route('cancelOrder', ['orderId' => $order->id]) }}" class="mb-3">
        @csrf
        @method('put')
        <button type="submit" class="btn btn-danger">Cancel Order</button>
    </form>
@endif
@else
    <p>
        @if($order->status == 'delivered')
            Order delivered. Unable to cancel.
        @else
        @if($order->status != 'cancelled')
    <p> Cancel your order 
        <a id="cancelLink" href="{{ route('verifyOrderPage', ['orderId' => $order->id]) }}">Click here</a>
    </p>
@else
    <p>Order already cancelled.</p>
@endif

        @endif
    </p>
@endif
                        
                        <div class="d-flex justify-content-between pt-2">
                            <p class="fw-bold mb-0"><b>Order Details</b></p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">Total</span> ₹{{ $order->total }}</p>
                        </div>

                        <div class="d-flex justify-content-between pt-2">
                            <p class="text-muted mb-0">Order Number: #00{{ $order->id }}</p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p class="text-muted mb-0">Order Date: {{ $order->created_at->format('d F Y') }}</p>

                        </div>


                        @else
                        <p>Order not found</p>
                        @endif
                    </div>
                    <div class="card-footer border-0 px-4 py-5"
                        style="background-color: #a8729a; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                        <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Total
                            paid: <span class="h2 mb-0 ms-2">₹{{ $order->total }}</span></h5>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection