@extends('layouts.head')

@section('content')
    <div class="container">
        <h2>Category List</h2>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('categories.add') }}" class="btn btn-primary">Add categories</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Serial Number</th>
                    <th>Category Name</th>
                    <th>Parent Category</th>
                    <th>Image</th>
                    <th>Is Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $serialNumber = 1; // Initialize the serial number counter
                @endphp
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $serialNumber }}</td>
                        <td>{{ $category->CategoryName }}</td>
                        <td>
                            @if($category->parentCategory)
                                {{ $category->parentCategory->CategoryName }}
                            @else
                                N/A
                            @endif          
                        </td>
                        <td>
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" style="max-width: 50px; max-height: 50px;">
                            @else
                                No image
                            @endif
                        </td>
                        <td>
                        <input type="checkbox" name="" data-category-id="{{ $category->id }}" {{ $category->is_featured ? 'checked' : '' }} onclick="toggleIsFeatured({{ $category->id }})">

                        </td>
                        <td>
                            <a href="{{ route('categories.edit', ['id' => $category->id]) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('categories.delete', ['id' => $category->id]) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @php
                        $serialNumber++; // Increment the serial number
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
    {{ $categories->links('custom-pagination') }}
    </div>
    <script>
        function toggleIsFeatured(categoryId) {
            var checkbox = $('input[type="checkbox"][data-category-id="' + categoryId + '"]');
            var isChecked = checkbox.prop('checked');
//alert(isChecked);
            // Toggle the is_featured status locally for a quick response
           // checkbox.prop('checked', !isChecked);

            // Make an AJAX request to update is_featured in the backend
            $.ajax({
                type: 'POST',
                url: '{{ route("categories.toggleFeatured") }}',
                data: {
                    categoryId: categoryId,
                    isFeatured: isChecked ? 1 : 0, // Toggle the value
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    alert(response.message);
                },
                error: function (error) {
                    console.error('Error:', error);
                    // Revert the checkbox state on error
                    checkbox.prop('checked', !isChecked);
                }
            });
        }
    </script>
@endsection
