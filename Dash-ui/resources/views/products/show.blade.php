@extends('layouts.head')

@section('content')
    <div class="container">
        <h2>Product List</h2>
        <p class="mr-2"><b>Total Products:</b> {{ $totalProductsCount }} </p>
        <div class="d-flex justify-content-end mb-3">
       
            <a href="{{ route('products.add') }}" class="btn btn-primary">Add Products</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Serial Number</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Images</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $serialNumber = 1; // Initialize the serial number counter
                @endphp
                @foreach($products as $product)
                    <tr>
                        <td>{{ $serialNumber }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->category->CategoryName }}</td>
                        <td>{{ $product->brand->brand_name }}</td>
                        <td>
                            @foreach($product->images as $image)
                                <img src="{{ asset('storage/' . $image->url) }}" alt="Product Image" style="max-width: 50px; max-height: 50px; margin-right: 5px;">
                            @endforeach
                        </td>
                        <td> 
                             <a href="{{ route('products.view', ['id' => $product->id]) }}" class="btn btn-primary">View</a>
                            <a href="{{ route('products.edit', ['id' => $product->id]) }}" class="btn btn-warning">Edit</a>
                            <a href="#" class="btn btn-danger" onclick="deleteProduct('{{ route('products.destroy', ['id' => $product->id]) }}', '{{ csrf_token() }}')">Delete</a>
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
    {{ $products->links('custom-pagination') }}
</div>
@endsection
<script>
    function deleteProduct(url, token) {
        if (confirm("Are you sure you want to delete this product?")) {
            // Create a form
            var form = document.createElement('form');
            form.setAttribute('method', 'POST');
            form.setAttribute('action', url);

            // Add CSRF token
            var csrfField = document.createElement('input');
            csrfField.setAttribute('type', 'hidden');
            csrfField.setAttribute('name', '_token');
            csrfField.setAttribute('value', token);
            form.appendChild(csrfField);

            // Add method spoofing for DELETE
            var methodField = document.createElement('input');
            methodField.setAttribute('type', 'hidden');
            methodField.setAttribute('name', '_method');
            methodField.setAttribute('value', 'DELETE');
            form.appendChild(methodField);

            // Append the form to the body
            document.body.appendChild(form);

            // Submit the form
            form.submit();
        }
    }
</script>