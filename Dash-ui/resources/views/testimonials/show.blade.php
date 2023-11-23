@extends('layouts.head')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Testimonials /</span> Show all</h4>

    <!-- Testimonials -->
    <div class="row mb-5">
    <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('testimonials.add') }}" class="btn btn-primary">Add Admin</a>
        </div>
        @foreach($testimonials as $testimonial)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <img class="card-img-top" src="{{ asset('storage/'.$testimonial->image) }}" alt="Card image cap" />
                <div class="card-body">
                    <h5 class="card-title">{{ $testimonial->name }}</h5>
                    <h6 class="card-subtitle text-muted">{{ $testimonial->company }} - {{ $testimonial->designation }}</h6>
                    <p class="card-text">
                        {{ $testimonial->content }}
                    </p>
                    <a href="{{ route('testimonials.edit', ['id' => $testimonial->id]) }}" class="btn btn-outline-primary">Edit</a>
                    <button class="btn btn-outline-danger" onclick="deleteTestimonial({{ $testimonial->id }})">Delete</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- /Testimonials -->
</div>

@endsection
