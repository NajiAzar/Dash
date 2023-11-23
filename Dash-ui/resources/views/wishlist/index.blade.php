@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')
    <h1 class="text-center">My Wishlist</h1>

    <div class="table-responsive mx-auto" style="width: 80%;">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($wishlistItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>
                            <button class="btn btn-primary" onclick="addToCart({{ $item->product->id }})">Add to Cart</button>
                            <button class="btn btn-danger" onclick="removeFromWishlist({{ $item->id }})">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function addToCart(productId) {
            // Implement the logic to add the product to the cart using JavaScript or AJAX.
            // You can use a POST request to a cart API endpoint.
        }

        function removeFromWishlist(wishlistItemId) {
        // Send an AJAX request to remove the product from the wishlist
        $.ajax({
            type: 'DELETE',
            url: `/wishlist/${wishlistItemId}`, // Use the route parameter
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.success) {
                    // Refresh the page or update the UI to reflect the removal
                    location.reload();
                } else {
                    alert('Failed to remove the product from your wishlist.');
                }
            }
        });
    }
    </script>
@endsection
