@extends('layouts.app') <!-- Use your own base template -->

@section('content')
  <!-- ##### Cart Page Start ##### -->
  <div class="cart-page section-padding-100">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="cart-title">
            <h2>Your Shopping Cart</h2>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="cart-table">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Remove</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Loop through cart items and display them -->
                  @foreach($cartItems as $cartItem)
                  <tr>
                    <td>{{ $cartItem->product->name }}</td>
                    <td>${{ $cartItem->product->price }}</td>
                    <td>
                      <input type="number" class="form-control" value="{{ $cartItem->quantity }}">
                    </td>
                    <td>${{ $cartItem->product->price * $cartItem->quantity }}</td>
                    <td>
                      <a href="{{ route('cart.remove', ['id' => $cartItem->id]) }}" class="btn btn-danger">Remove</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-lg-6">
          <div class="coupon-code">
            <input type="text" class="form-control" placeholder="Coupon Code">
            <button class="btn essence-btn">Apply Coupon</button>
          </div>
        </div>
        <div class="col-12 col-lg-6">
          <div class="cart-total-amount">
            <h5>Cart Total</h5>
            <h5>Total: ${{ $cartTotal }}</h5>
            <a href="{{ route('checkout') }}" class="btn essence-btn">Proceed to Checkout</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ##### Cart Page End ##### -->
@endsection
