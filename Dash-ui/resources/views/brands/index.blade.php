@extends('layouts.head')

@section('content')
    <div class="container">
        <h2>Brands</h2>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('brands.add') }}" class="btn btn-primary">Add brands</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Serial Number</th>
                    <th>Brand Name</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $serialNumber = ($brands->currentPage() - 1) * $brands->perPage() + 1; // Calculate the starting serial number
                @endphp
                @foreach($brands as $brand)
                    <tr>
                        <td>{{ $serialNumber }}</td>
                        <td>{{ $brand->brand_name }}</td>
                        <td>
                            @if($brand->image)
                                <img src="{{ asset('storage/' . $brand->image) }}" alt="Brand Image" style="max-width: 50px; max-height: 50px;">
                            @else
                                No image
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('brands.edit', ['brand' => $brand->id]) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('brands.destroy', ['brand' => $brand->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this brand?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @php
                        $serialNumber++;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
    {{ $brands->links('custom-pagination') }}
</div>
@endsection
