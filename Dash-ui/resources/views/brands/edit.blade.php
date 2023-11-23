@extends('layouts.head')

@section('content')
    <div class="container">
        <h2>Edit Brand</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('brands.update', ['brand' => $brand->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="brand_name">Brand Name</label>
                <input type="text" class="form-control" id="brand_name" name="brand_name" value="{{ old('brand_name', $brand->brand_name) }}">
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/png, image/jpeg" onchange="previewImage(event)">
                <img id="preview" src="{{ asset('storage/' . $brand->image) }}" alt="Image preview" style="max-width: 100px; max-height: 100px;" />
            </div>
<br>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
