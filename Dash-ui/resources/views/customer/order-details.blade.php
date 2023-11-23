@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="osahan-account-page-right shadow-sm bg-white p-4 h-100">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                        <h4 class="font-weight-bold mt-0 mb-4">My Orders</h4>

                        @foreach($orders as $order)
                        <div class="bg-white card mb-4 order-list shadow-sm">
                            <div class="gold-members p-4">
                                <h6 class="mb-2">Order #00{{ $order->id }}</h6>
                                <p class="text-gray mb-3"><b>Total Paid: </b> ₹{{ $order->total }}</p>
                                @if($order->shippingAddress)
                                <p class="text-gray mb-1"><i class="icofont-location-arrow"></i><b>Shipping Address:</b>
                                    {{ $order->shippingAddress->address }} , {{ $order->shippingAddress->postcode }} ,
                                    {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} , {{
                                    $order->shippingAddress->phone_number }}</p>
                                @endif
                                @foreach($order->orderDetails as $orderDetail)
                                <div class="d-flex">
                                    <img src="{{ asset('storage/' . $orderDetail->product->images->first()->url) }}"
                                        alt="{{ $orderDetail->product->name }}" class="mr-2"
                                        style="width: 50px; height: 50px;">
                                    <p class="text-dark">{{ $orderDetail->product->name }} x (<b>{{
                                            $orderDetail->quantity }}</b>)</p>
                                </div>
                                <br />
                                @endforeach
                                <hr>
                                <div class="float-right">
                                    @if($order->status == 'cancelled')
                                    <button type="button" class="btn btn-warning"> Order Cancelled</button>
                                    @elseif($order->status == 'delivered')
                                    <div class="row">
    <div class="col-md-6">
        <!-- Your feedback tab and form goes here -->
        <button class="btn btn-sm btn-primary" id="feedbackTabButton" style="display: none;">
            <i class="icofont-ui-rate-add"></i> Add Feedback
        </button>

        <ul class="nav nav-tabs" id="feedbackTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="addTab" data-bs-toggle="tab" href="#addFeedback" role="tab" aria-controls="addFeedback" aria-selected="false">Add Feedback</a>
            </li>
        </ul>

        <div class="tab-content mt-2">
            <!-- Add Feedback Tab -->
            <div class="tab-pane fade" id="addFeedback" role="tabpanel" aria-labelledby="addTab">
                <!-- Your feedback form goes here -->
                <form id="feedbackForm" action="{{ route('feedback.store', ['orderNumber' => $order->id]) }}" method="post">
                    @csrf
                    <!-- Add your form fields -->
                    <div class="mb-3">
                        <textarea id="feedbackInput" name="comment" class="form-control" rows="3" placeholder="Enter your feedback"></textarea>
                    </div>
                    <button type="button" class="btn btn-primary mt-3" onclick="submitFeedbackForm()">Submit Feedback</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <!-- Track order button -->
        <a class="btn btn-sm btn-outline-primary" href="{{ route('track', ['order_number' => $order->id, '_token' => csrf_token()]) }}">
            <i class="icofont-headphone-alt"></i> Track order
        </a>
    </div>
</div>

                                    @else
                                    <a class="btn btn-sm btn-outline-primary"
                                        href="{{ route('track', ['order_number' => $order->id, '_token' => csrf_token()]) }}">
                                        <i class="icofont-headphone-alt"></i> Track order
                                    </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add this script at the end of your HTML, after including Bootstrap and any other dependencies -->
<script>
    // Function to show the feedback tab and textarea
    function showFeedbackTab() {
        $('#feedbackTabs a[href="#addFeedback"]').tab('show');
    }

    // Function to handle the form submission
    function submitFeedbackForm() {
        // You can add additional validation here if needed

        // Submit the form using AJAX
        $.ajax({
            url: "{{ route('feedback.store', ['orderNumber' => $order->id]) }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                comment: $('#feedbackForm textarea[name="comment"]').val()
            },
            success: function (response) {
                // Handle success (e.g., show success message)
                alert('Feedback submitted successfully!');
                 location.reload();
            },
            error: function (error) {
                // Handle error (e.g., show error message)
                alert('Failed to submit feedback. Please try again.');
            }
        });
    }

    // Attach click event to the button to show the feedback tab
    $('#feedbackTabButton').click(function () {
        showFeedbackTab();
    });
</script>

@endsection<script>
    // Function to show the feedback tab and textarea
    function showFeedbackTab() {
        $('#feedbackTabs a[href="#addFeedback"]').tab('show');
    }

    // Function to handle the form submission
    function submitFeedbackForm() {
       
        $.ajax({
            url: "{{ route('feedback.store', ['orderNumber' => $order->id]) }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                comment: $('#feedbackForm textarea[name="comment"]').val(),
                orderNumber: '{{ $order->id }}' // Include the orderNumber in the data
            },
            success: function (response) {
                // Handle success (e.g., show success message)
                alert('Feedback submitted successfully!');
                // You can also update the UI, reset the form, or perform other actions here
            },
            error: function (error) {
                // Handle error (e.g., show error message)
                alert('Failed to submit feedback. Please try again.');
            }
        });
    }

    // Attach click event to the button to show the feedback tab
    $('#feedbackTabButton').click(function () {
        showFeedbackTab();
    });
</script>