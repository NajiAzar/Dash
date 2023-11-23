@extends('layouts.head')

@section('content')
    <div class="container">
        <h2>Add Product</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-select" id="category_id" name="category_id">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->CategoryName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="brand_id">Brand</label>
                <select class="form-select" id="brand_id" name="brand_id">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="images">Images</label>
                <input type="file" class="form-control" id="images" name="images[]" accept="image/png, image/jpeg" multiple>
            </div>

            <!-- Image preview container -->
            <div class="image-preview" id="imagePreview"></div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        // Function to preview images
function previewImages(event) {
    var preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    if (event.target.files) {
        Array.from(event.target.files).forEach(function(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement('img');
                img.setAttribute('src', e.target.result);
                img.classList.add('img-preview'); // Add the img-preview class
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
}

// Attach an event listener to the file input
document.getElementById('images').addEventListener('change', previewImages);

    </script>
@endsection