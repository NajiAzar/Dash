@extends('layouts.head')
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Testimonials /</span> Add</h4>
              <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('testimonials.show') }}" class="btn btn-primary">Show all</a>
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

              <div class="row">
                <div class="col-md-12">
                 
                <div class="card mb-4">
    <h5 class="card-header">Testimonial Details</h5>
    <div class="card-body">
        <form id="formTestimonial" method="POST" action="{{ route('testimonials.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" autofocus />
            </div>

            <div class="mb-3">
                <label for="company" class="form-label">Company</label>
                <input class="form-control" type="text" id="company" name="company" value="{{ old('company') }}" />
            </div>

            <div class="mb-3">
                <label for="designation" class="form-label">Designation</label>
                <input class="form-control" type="text" id="designation" name="designation" value="{{ old('designation') }}" />
            </div>

            <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input class="form-control" type="file" id="image" name="image" accept="image/png, image/jpeg" onchange="previewImage(event)" />
        <img id="preview" src="#" alt="Image preview" style="display: none; max-width: 100px; max-height: 100px;" />
    </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5">{{ old('content') }}</textarea>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Save Testimonial</button>
                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
            </div>
        </form>
    </div>
</div>

                    <!-- /Account -->
                  </div>
              
                </div>
              </div>
            </div>
            <!-- / Content -->
            @endsection 