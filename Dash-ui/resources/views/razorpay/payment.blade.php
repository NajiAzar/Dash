<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
</head>

<body>

    <button id="rzp-button1">Pay with Razorpay</button>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
    var options = {
    "key": '{{ config('services.razorpay.key') }}',
    "amount": '{{ $razorpayOrder->amount }}',
    "name": "Acme Corp",
    "description": "Buy best price",
    "image": "https://cdn.razorpay.com/logos/FFATTsJeURNMxx_medium.png",
    "prefill": {
        "name": "{{ $order->shippingAddress->first_name . ' ' . $order->shippingAddress->last_name }}",
        "email": "{{ $order->shippingAddress->email_address }}",
        "contact": "{{ $order->shippingAddress->phone_number }}",
    },
    "notes": {
        "address": "{{ $order->shippingAddress->address }}",
        "merchant_order_id": "{{ $order->id }}",
    },
    "theme": {
        "color": "#99cc33"
    },
    "order_id": '{{ $razorpayOrder->id }}',
    // Add a callback function for the success event
    "handler": function (response) {
        console.log(response);
        var transactionId = response.razorpay_payment_id;
        console.log('transaction_id:', transactionId);
        if (transactionId) {
        var updateUrl = '/update-order-status/' + '{{ $order->id }}' + '/' + transactionId;
        fetch(updateUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                status_paid: true,
                transaction_id: transactionId,
            }),
        })
        .then(response => {
            // Log the raw response for debugging
            console.log('Raw Response:', response);

            // Check if the response is a valid JSON
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            // Parse the response as JSON
            return response.json();
        })
        .then(data => {
            console.log('JSON Response:', data);
            console.log('Transaction ID:', data.transaction_id);
            console.log('Status Paid:', data.status_paid);
            console.log('Order Details:', data.id);

            if (data.status_paid) {
                window.location.href = '/thank-you/' + data.id;
            }
        })
        .catch(error => {
            // Handle errors, including non-JSON responses
            console.error('Error:', error);

            // Log the full response for debugging
            return error.text().then(text => {
                console.error('Full Response:', text);
                throw error; // rethrow the error to maintain the promise chain
            });
        });
    } else {
            // Update order status to "cancelled" and redirect to order failure page
            fetch('/cancel-order/' + '{{ $order->id }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: 'cancelled',
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Order Cancelled:', data);
                window.location.href = '/order-failure';
            })
            .catch(error => {
                console.error('Error:', error);
                window.location.href = '/order-failure';
            });
        }
    }
};

var rzp = new Razorpay(options);

document.getElementById('rzp-button1').onclick = function (e) {
    rzp.open();
    e.preventDefault();
}
</script>
</body>

</html>