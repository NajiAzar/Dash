@extends('layouts.app') <!-- Use your own base template -->

@section('content')
<div class="row">
    @if(auth()->guard('customer')->check())
        <!-- If the customer is logged in, show the profile details -->
        <div class="col-5 col-md-5">
            <div class="checkout_details_area mt-50" style="margin-left: 60px;">
                <div class="cart-page-heading mb-30">
                    <h5>Profile Details</h5>
                    <table class="table table-dark">
                        <tbody>
                            <tr>
                                <th scope="row">Name</th>
                                <td>{{ auth()->guard('customer')->user()->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td>{{ auth()->guard('customer')->user()->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Phone</th>
                                <td>{{ auth()->guard('customer')->user()->phone }}</td>
                            </tr>
                            <!-- Add more profile details as needed -->
                        </tbody>
                    </table>
                    <a href="{{ route('editProfile') }}" class="btn btn-warning">Edit Profile</a>
                    <a href="{{ route('orderDetails') }}" class="btn btn-outline-info">Order Details</a>
                    <a href="{{ route('changepassword') }}" class="btn btn-outline-info">Change password</a>

                </div>
            </div>
        </div>
          <!-- Logout Section -->
          <div class="col-4 col-md-4" >
            <div class="checkout_details_area mt-50" style="margin-left: 60px;">
                <div class="cart-page-heading mb-30">
                    <h5>Logout</h5>
                    <form action="{{ route('logoutcust') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-button">
                            <i class="fas fa-sign-out-alt"></i> <!-- Replace with your logout icon class -->
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
    <!-- If the customer is logged out, show the login and create sections -->
    <div class="col-6 col-md-6">
        <div class="checkout_details_area mt-50" style="margin-left: 60px;">
            <div class="cart-page-heading mb-30">
                <h5>Login</h5>
                <form action="{{ route('customerLogin') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="email">Email Address <span>*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="password">Password <span>*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                        <a href="{{ route('password.custemail')}}" style="color:#41b3ee !important;">Forgot Password ?</a>

                        </div>

                        <!-- You can remove the "Phone Number" input field -->

                        <!-- Your existing address fields can go here if needed -->

                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Registration Section -->
    <div class="col-3 col-md-3">
        <div class="checkout_details_area mt-50" style="margin-left: 60px;">
            <div class="cart-page-heading mb-30">
                <h5>Create an Account</h5>
                <div class="col-12 mt-3">
                    <a href="{{ route('register.customer') }}" class="btn btn-primary">Create</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
