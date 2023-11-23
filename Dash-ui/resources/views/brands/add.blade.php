@extends('layouts.head')

@section('content')
    <div class="container">
        <h2>Add Brand</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="brand_name">Brand Name</label>
                <input type="text" class="form-control" id="brand_name" name="brand_name" value="{{ old('brand_name') }}">
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/png, image/jpeg" onchange="previewImage(event)">
                <img id="preview" src="#" alt="Image preview" style="display: none; max-width: 100px; max-height: 100px;" />
            </div>
<br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
