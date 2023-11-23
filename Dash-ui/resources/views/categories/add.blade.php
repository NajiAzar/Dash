@extends('layouts.head')

@section('content')
    <div class="container">
        <h2>Add Category</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="CategoryName">Category Name</label>
                <input type="text" class="form-control" id="CategoryName" name="CategoryName" value="{{ old('CategoryName') }}">
            </div>
            <div class="mb-3">
            <label for="ParentCategoryID" class="form-label">Parent Category</label>
            <select class="form-select" id="ParentCategoryID" name="ParentCategoryID">
                <option value="">Select Parent Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id  }}">{{ $category->CategoryName }}</option>
                @endforeach
                </select>
                            </div>
          
            <div class="form-group">
    <label for="image">Image</label>
    <input type="file" class="form-control" id="image" name="image" accept="image/png, image/jpeg" onchange="previewImage(event)">
    <img id="preview" src="#" alt="Image preview" style="display: none; max-width: 100px; max-height: 100px;" />
</div>

            <div class="form-group">
                <label for="Description">Description</label>
                <textarea class="form-control" id="Description" name="Description" rows="3">{{ old('Description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
