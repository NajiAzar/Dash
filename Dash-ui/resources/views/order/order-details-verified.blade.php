@extends('layouts.app')

@section('content')
    <h1>Order Details</h1>

    @if(isset($order))
        <!-- Display order details here -->
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
        @if($order->status != 'delivered')
        <form method="post" action="{{ route('processCancelOrder', ['orderId' => $order->id]) }}" class="mb-3">
              @csrf
                @method('put')
                <button type="submit" class="btn btn-danger">Cancel Order</button>
            </form>

           
        @else
            <p>Order delivered. Unable to cancel.</p>
        @endif
    @else
        <p>Order not found</p>
    @endif
@endsection
