@extends('layouts.head')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="bx bx-user me-1"></i> Account</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bx bx-bell me-1"></i> Notifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bx bx-link-alt me-1"></i> Connections</a>
            </li>
        </ul>

        <div class="card mb-4">
            <h5 class="card-header">Profile Details</h5>
            <hr class="my-0" />
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Name</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" autofocus />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="john.doe@example.com" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <h5 class="card-header">Change Password</h5>
            <hr class="my-0" />
            <div class="card-body">
                <form action="{{ route('profile.updatePassword') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input class="form-control @error('currentPassword') is-invalid @enderror" type="password" id="currentPassword" name="currentPassword" required />
                        @error('currentPassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input class="form-control @error('newPassword') is-invalid @enderror" type="password" id="newPassword" name="newPassword" required />
                        @error('newPassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input class="form-control @error('confirmPassword') is-invalid @enderror" type="password" id="confirmPassword" name="confirmPassword" required />
                        @error('confirmPassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
