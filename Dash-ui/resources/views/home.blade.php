

@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                     Hi there, regular user
                </div>
                <p class="text-center">
                    
                        <!-- <span>Logout</span>
                        <a href="{{ route('logout') }}">
                            <span>Logout</span>
                        </a> -->
                       
                    </p>
            </div>
        </div>
    </div>
</div>

@endsection

