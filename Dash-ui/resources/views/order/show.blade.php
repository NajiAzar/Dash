@extends('layouts.head')

@section('content')
    <div class="container">
        <h2>Orders</h2>
        <form class="row mb-3" action="{{ route('orders.filter') }}" method="get">
    @csrf
    <div class="col-md-5">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Enter Order Number" name="order_number">
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <select class="form-control" id="statusFilter" name="status">
                <option value="">All</option>
                <option value="pending">Pending</option>
                <option value="processed">Processed</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <label for="statusFilter" class="mr-2">Filter by Status:</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select class="form-control" id="paymentMethodFilter" name="payment_method">
                <option value="">All</option>
                <option value="cash_on_delivery">Cash on Delivery</option>
                <option value="razorpay">Razorpay</option>
            </select>
            <label for="paymentMethodFilter" class="mr-2">Filter by Payment Method:</label>
        </div>
    </div>
    <div class="col-md-2">
        <!-- Filter button -->
        <button type="submit" class="btn btn-primary btn-block">Filter</button>
    </div>
</form>

<table class="table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Customer name</th>
            <th>Total</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Payment Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>#00{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d F Y') }}</td>
                @if($order->customer)
                    <td>{{ $order->customer->name }}</td>
                @else
                    <td>Customer not found</td>
                @endif
                <td>{{ $order->total }}</td>
                <td>{{ $order->payment_method }}</td>
                <td>
                    <select class="form-control" id="statusDropdown_{{ $order->id }}" @if ($order->status == 'cancelled' || $order->status == 'delivered') disabled @endif
                        style="color: {{ $order->status == 'cancelled' ? 'red' : ($order->status == 'delivered' ? 'inherit' : 'initial') }}">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>Processed</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>

                    <script>
                        // Add this script to prevent interaction with the disabled dropdown
                        document.getElementById('statusDropdown_{{ $order->id }}').addEventListener('click', function (event) {
                            event.preventDefault();
                        });
                    </script>
                </td>
                <td>{{ $order->status_paid ? 'Paid' : 'Not Paid' }}</td>
                <td>
                    <a href="{{ route('orders.view', ['id' => $order->id]) }}" class="btn btn-warning">View</a>
                    <button class="btn btn-primary update-status-btn" data-order-id="{{ $order->id }}">Update Status</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

    </div>
    <div class="d-flex justify-content-center">
        {{ $orders->links('custom-pagination') }}
    </div>

   
    <script>
        $(document).ready(function () {
            $('.update-status-btn').click(function () {
                var orderId = $(this).data('order-id');
                var newStatus = $('#statusDropdown_' + orderId).val();

                // Send AJAX request to update the status
                $.ajax({
                    url: "{{ route('orders.updateStatus') }}",
                    type: "POST",
                    data: {
                        order_id: orderId,
                        status: newStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            alert('Status updated successfully!');
                            location.reload();
                        } else {
                            alert('Failed to update status. Please try again.');
                        }
                    }
                });
            });
        });
    </script>
@endsection
