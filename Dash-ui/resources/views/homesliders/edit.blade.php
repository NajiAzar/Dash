@extends('layouts.head')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home Sliders /</span> Edit</h4>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('homesliders.show') }}" class="btn btn-primary">Show all</a>
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
            <h5 class="card-header">Home Sliders</h5>
            <div class="card-body">
                <form id="formTestimonial" method="POST" action="{{ route('homesliders.update', $homeslider->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input class="form-control" type="text" id="title" name="title" value="{{ old('title', $homeslider->title) }}" autofocus />
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input class="form-control" type="text" id="description" name="description" value="{{ old('description', $homeslider->description) }}" />
                    </div>

                    <div class="mb-3">
                        <label for="target_url" class="form-label">Target Url</label>
                        <input class="form-control" type="text" id="target_url" name="target_url" value="{{ old('target_url', $homeslider->target_url) }}" />
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/png, image/jpeg" onchange="previewImage(event)" />
                        <img id="preview" src="{{ asset('storage/'.$homeslider->image) }}" alt="Image preview" style="max-width: 100px; max-height: 100px;" />
                    </div>

               
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save HomeSlide</button>
                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
