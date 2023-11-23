@extends('layouts.app') 

@section('content')
<div class="col-12 col-md-6">
    <div class="checkout_details_area mt-50" style="margin-left: 60px;">
        <div class="cart-page-heading mb-30">
            <h5>Edit Profile</h5>
        </div>

        <form action="{{ route('updateProfile') }}" method="post">
            @csrf
            <div class="row">
            @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                <div class="col-12 mb-3">
                    <label for="name">Name <span>*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ auth()->guard('customer')->user()->name }}" required>
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="email">Email Address <span>*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ auth()->guard('customer')->user()->email }}" required>
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="phone">Phone Number <span>*</span></label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ auth()->guard('customer')->user()->phone }}" required>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
            <br>
        </form>
    </div>
</div>
@endsection
