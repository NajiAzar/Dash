@extends('layouts.app')

@section('content')
<div class="col-12 col-md-6">
    <div class="checkout_details_area mt-50" style="margin-left: 60px;">
        <div class="cart-page-heading mb-30">
            <h5>Change Password</h5>
        </div>

        <form action="{{ route('updatePassword') }}" method="post">
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
            @csrf
            <div class="row">
                <div class="col-12 mb-3">
                    <label for="current_password">Current Password <span>*</span></label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                    @error('current_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="new_password">New Password <span>*</span></label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                    @error('new_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="confirm_password">Confirm Password <span>*</span></label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    @error('confirm_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </div>
            <br>
        </form>
    </div>
</div>
@endsection
