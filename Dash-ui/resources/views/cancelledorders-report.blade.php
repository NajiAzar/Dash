@extends('layouts.head')

@section('content')
<br/>
<div class="container">
    <h2>Cancelled Order Report</h2>

    <!-- Search and Date Range Form -->
    <form action="{{ route('cancelledorders.report') }}" method="get" class="mb-4">
        <div class="row">
        @error('startDate')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    @error('endDate')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
            <!-- Keyword Search -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="keyword">Search by Customer Name:</label>
                    <input type="text" class="form-control" id="keyword" name="keyword" value="{{ request('keyword') }}" placeholder="Enter customer name">
                </div>
            </div>

            <!-- Start Date -->
            <div class="col-md-4">
                <label for="startDate">Start Date:</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="startDate" name="startDate" autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                    </div>
                </div>
            </div>

            <!-- End Date -->
            <div class="col-md-4">
                <label for="endDate">End Date:</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="endDate" name="endDate" autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                    </div>
                </div>
            </div>

            <!-- Search button -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
        <br/>
        <div class="col-md-2">
    <button type="submit" class="btn btn-success" name="export" value="true">Export</button>
</div>
    </form>

    <!-- Display net total at the top -->
    <div class="d-flex justify-content-between mb-4">
        <h4>Net Total: ₹ {{ $netTotal }}</h4>
        <h4>Number of Cancelled Orders: {{ $totalcancelledorders->count() }}</h4>
    </div>

    <!-- Sales Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Order Cancelled Date</th>
                <th>Customer name</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cancelledorders as $cancelledorder)
            <tr>
                <td>#00{{ $cancelledorder->id }}</td>
                <td>{{ $cancelledorder->created_at->format('d F Y') }}</td>
                <td>{{ $cancelledorder->cancelled_date->format('d F Y') }}</td>
                <td>{{ $cancelledorder->shippingAddress->first_name }} {{ $cancelledorder->shippingAddress->last_name }}</td>
                <td>{{ $cancelledorder->status }}</td>
                <td>{{ $cancelledorder->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $cancelledorders->links('custom-pagination') }}
    </div>
</div>

<!-- Initialize Pikaday -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Start Date Picker
        var startDatePicker = new Pikaday({
            field: document.getElementById('startDate'),
            format: 'YYYY-MM-DD',
            yearRange: [2000, moment().year()],
        });

        // End Date Picker
        var endDatePicker = new Pikaday({
            field: document.getElementById('endDate'),
            format: 'YYYY-MM-DD',
            yearRange: [2000, moment().year()],
        });
    });
</script>

@endsection
