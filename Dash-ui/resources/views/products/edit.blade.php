@extends('layouts.head')

@section('content')
    <div class="container">
        <h2>Edit Product</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}">
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-select" id="category_id" name="category_id">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->CategoryName }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="brand_id">Brand</label>
                <select class="form-select" id="brand_id" name="brand_id">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                            {{ $brand->brand_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Display existing images -->
            <div class="form-group">
                <label for="existing_images">Existing Images</label>
                @foreach ($product->images as $image)
                    <img src="{{ asset('storage/' . $image->url) }}" alt="Product Image" style="max-width: 100px; max-height: 100px; margin-right: 5px;">
                @endforeach
            </div>

            <!-- Allow adding/editing multiple images -->
            <div class="form-group">
                <label for="images">Update Images</label>
                <input type="file" class="form-control" id="images" name="images[]" accept="image/png, image/jpeg" multiple>
            </div>

            <!-- Image preview for updated images -->
            <div class="image-preview" id="imagePreview"></div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script>
        // Function to preview images
        function previewImage(event) {
            var preview = document.getElementById('preview');
            preview.innerHTML = '';

            if (event.target.files) {
                Array.from(event.target.files).forEach(function(file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.setAttribute('src', e.target.result);
                        img.setAttribute('class', 'img-preview');
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        // Attach an event listener to the file input
        document.getElementById('images').addEventListener('change', previewImage);

        
    </script>
 <script>
        // Function to preview images for update
        function previewImagesForUpdate(event) {
            var preview = document.getElementById('imagePreview');
            preview.innerHTML = '';

            if (event.target.files) {
                Array.from(event.target.files).forEach(function(file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.setAttribute('src', e.target.result);
                        img.setAttribute('class', 'img-preview');
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        // Attach an event listener to the file input for image update
        document.getElementById('images').addEventListener('change', previewImagesForUpdate);
    </script>

@endsection
