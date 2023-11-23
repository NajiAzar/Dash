
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Verify Your Order</h2>
    <form method="post" action="{{ route('verifyOrderemail', ['orderId' => $order->id]) }}">
        @csrf
        <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="emailAddress">Email Address:</label>
            <input type="email" class="form-control" id="emailAddress" name="emailAddress" required>
        </div>
        </div>
        <button type="submit" class="btn btn-primary">Verify Order</button>
    </form>
<br>
</div>
@endsection
