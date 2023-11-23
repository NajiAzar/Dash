@extends('layouts.head')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home Slides /</span> Show all</h4>

    <!-- Testimonials -->
    <div class="row mb-5">
    <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('homesliders.add') }}" class="btn btn-primary">Add Home Slide</a>
        </div>
        @foreach($homesliders as $homeslider)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <img class="card-img-top" src="{{ asset('storage/'.$homeslider->image) }}" alt="Card image cap" />
                <div class="card-body">
                    <h5 class="card-title">Title : {{ $homeslider->title }}</h5>
                    <h6 class="card-subtitle text-muted">Description : {{ $homeslider->description }}</h6><br/>
                    <h6 class="card-subtitle text-muted">Target URL : {{ $homeslider->target_url }}</h6><br/>
                   
                    <a href="{{ route('homesliders.edit', ['id' => $homeslider->id]) }}" class="btn btn-outline-primary">Edit</a>
                    <button class="btn btn-outline-danger" onclick="deleteHomeSlide({{ $homeslider->id }})">Delete</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- /Testimonials -->
</div>

@endsection
