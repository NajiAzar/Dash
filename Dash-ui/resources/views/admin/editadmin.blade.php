@extends('layouts.head')
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Edit Admin /</span> Account</h4>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('showadmin') }}" class="btn btn-primary">List Admin</a>
        </div>
        <!-- Display validation errors -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="card mb-4">
            <h5 class="card-header">Edit Profile Details</h5>
            <hr class="my-0" />
            <div class="card-body">
                <form id="formAccountSettings" method="POST" action="{{ route('admin.update', $admin->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Name</label>
                            <input class="form-control" type="text" id="firstName" name="firstName" value="{{ $admin->name }}" autofocus />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control" type="email" id="email" name="email" value="{{ $admin->email }}" placeholder="john.doe@example.com" />
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <a href="{{ route('showadmin') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
            <!-- /Account -->
            <!-- <div class="card mb-4">
            <h5 class="card-header">Change Password</h5>
            <hr class="my-0" />
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input class="form-control @error('currentPassword') is-invalid @enderror" type="password" id="currentPassword" name="currentPassword" required />
                        @error('currentPassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
    <label for="password" class="form-label">New Password</label>
    <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" required />
    @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" id="password_confirmation" name="password_confirmation" required />
    @error('password_confirmation')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
        </div> -->
    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->
@endsection
