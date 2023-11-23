@extends('layouts.head')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Testimonials /</span> Edit</h4>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('testimonials.show') }}" class="btn btn-primary">Show all</a>
        </div>

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
            <h5 class="card-header">Testimonial Details</h5>
            <div class="card-body">
                <form id="formTestimonial" method="POST" action="{{ route('testimonials.update', $testimonial->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $testimonial->name) }}" autofocus />
                    </div>

                    <div class="mb-3">
                        <label for="company" class="form-label">Company</label>
                        <input class="form-control" type="text" id="company" name="company" value="{{ old('company', $testimonial->company) }}" />
                    </div>

                    <div class="mb-3">
                        <label for="designation" class="form-label">Designation</label>
                        <input class="form-control" type="text" id="designation" name="designation" value="{{ old('designation', $testimonial->designation) }}" />
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/png, image/jpeg" onchange="previewImage(event)" />
                        <img id="preview" src="{{ asset('storage/'.$testimonial->image) }}" alt="Image preview" style="max-width: 100px; max-height: 100px;" />
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="5">{{ old('content', $testimonial->content) }}</textarea>
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save Testimonial</button>
                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
