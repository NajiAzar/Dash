@extends('layouts.app') <!-- Use your own base template -->

@section('content')
<div class="col-12 col-md-6">
    <div class="checkout_details_area mt-50" style="margin-left: 60px;">
        <div class="cart-page-heading mb-30">
            <h5>Registration</h5>
        </div>

        <form action="{{ route('registration') }}" method="post">
            @csrf
            <div class="row">
            <div class="col-12 mb-3">
    <label for="name">Name <span>*</span></label>
    <input type="text" class="form-control" id="name" name="name" required>
    @error('name')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-12 mb-3">
    <label for="email">Email Address <span>*</span></label>
    <input type="email" class="form-control" id="email_id" name="email_id" required>
    @error('email_id')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-12 mb-3">
    <label for="phone">Phone Number <span>*</span></label>
    <input type="tel" class="form-control" id="phone" name="phone" required>
 
</div>

<div class="col-12 mb-3">
    <label for="password">Password <span>*</span></label>
    <input type="password" class="form-control" id="password" name="password" required>
    @error('password')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-12 mb-3">
    <label for="confirm_password">Confirm Password <span>*</span></label>
    <input type="password" class="form-control" id="confirm_password" name="password_confirmation" required>
    @error('password_confirmation')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>


                <!-- Your existing address fields can go here -->

                <div class="col-12">
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
