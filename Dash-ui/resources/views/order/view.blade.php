@extends('layouts.head')

@section('content')
<div class="row">
                <!-- Inline text elements -->
                <div class="col">
                  <div class="card mb-4">
                    <h5 class="card-header">Order Details</h5>
                    <div class="card-body">
                    @if($order)
                      <table class="table table-borderless">
                        <tbody>
                          <tr>
                            <td class="align-middle"><small class="text-light fw-semibold">Order ID</small></td>
                            <td class="py-3">
                              <p class="mb-0">#00<mark>{{ $order->id }}</mark> </p>
                            </td>
                          </tr>
                          <tr>
                            <td class="align-middle"><small class="text-light fw-semibold">Date</small></td>
                            <td class="py-3">
                              <p class="mb-0">{{ $order->created_at->format('d F Y') }}</p>
                            </td>
                          </tr>
                          <tr>
                            <td><small class="text-light fw-semibold">Customer Name</small></td>
                            <td class="py-3">
                              <p class="mb-0">   {{ optional($order->customer)->name ?? 'Customer' }} </p>
                            </td>
                          </tr>
                          <tr>
                            <td><small class="text-light fw-semibold">Total </small></td>
                            <td class="py-3">
                              <p class="mb-0"> ₹ <mark>{{ $order->total }}</mark>
                              </p>
                            </td>
                          </tr>
                          <tr>
                            <td><small class="text-light fw-semibold">Payment method </small></td>
                            <td class="py-3">
                              <p class="mb-0">{{ $order->payment_method }} </p>
                            </td>
                          </tr>
                        
                          <tr>
                            <td><small class="text-light fw-semibold">order details</small></td>
                            <td class="py-3">
                            @foreach($order->orderDetails as $detail)
                                <div class="card shadow-0 border mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="{{ asset('storage/' . $detail->product->images->first()->url) }}"
                                                    class="img-fluid" alt="{{ $detail->product->name }}">
                                            </div>
                                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0">Product Name:{{ $detail->product->name }}</p>
                                            </div>
                                          
                                           
                                            <div
                                                class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0 small">Qty: {{ $detail->quantity }}</p>
                                            </div>
                                            <div
                                                class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0 small">Unit Price :₹{{ $detail->product->price }}</p>
                                            </div>
                                        </div>
                                        <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                        <div class="row d-flex align-items-center">
                                         
                                            <div class="col-md-10">
                                             
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </td>
                          </tr>
                          <tr>
                            <td><small class="text-light fw-semibold">Billing Address</small></td>
                            <td class="py-3">
                            <p>{{ $order->billingAddress->address }}, {{ $order->billingAddress->city }}, {{ $order->billingAddress->state }},Pin:{{ $order->billingAddress->postcode }}</p>
                            </td>
                          </tr>
                          <tr>
                            <td><small class="text-light fw-semibold">Shipping Address</small></td>
                            <td>
                              <p>{{ $order->shippingAddress->address }}, {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }},Pin:{{ $order->shippingAddress->postcode }}</p>
                              
                            </td>
                            
                          </tr>
                          <tr>
                            <td><small class="text-light fw-semibold">Phone Number</small></td>
                            <td class="py-3">
                              <p class="mb-0"><em>{{ $order->shippingAddress->phone_number }}</em></p>
                            </td>
                          </tr>
                          <tr>
                            <td><small class="text-light fw-semibold">Email</small></td>
                            <td class="py-3">
                              <p class="mb-0"><em>{{ $order->shippingAddress->email_address }}</em></p>
                            </td>
                          </tr>

                          <tr>
    <td><small class="text-light fw-semibold">Order Feedback Details</small></td>
    <td class="py-3">
        <div class="card shadow-0 border mb-4">
            <div class="card-body">
                <div class="row">
                @if($orderFeedbacks->isEmpty())
                    <div class="row d-flex align-items-center">
                        <div class="col-md-12 text-center">
                            <p class="text-muted mb-0 small">No feedback yet!</p>
                        </div>
                    </div>
                @else
                    
                    <div class="col-md-4 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0 small">Feedback</p>
                    </div>
                    <div class="col-md-3 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0 small">Date of Feed back</p>
                    </div>
                </div>
              
                    @foreach($orderFeedbacks as $feedback)
                        <div class="row d-flex align-items-center">
                            
                            <div class="col-md-4 text-center d-flex justify-content-center align-items-center">
                                <p class="text-muted mb-0 small">{{ $feedback->comment }}</p>
                            </div>
                            <div class="col-md-3 text-center d-flex justify-content-center align-items-center">
                                <p class="text-muted mb-0 small">{{ $feedback->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </td>
</tr>
                        </tbody>
                      </table>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              @endsection
