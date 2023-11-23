<h1>Order Confirmation</h1>

<p>Dear {{ $customer->name }},</p>

<p>Your order with order ID {{ $order->id }} has been confirmed.</p>

<h2>Order Details:</h2>
 
<ul>
    @foreach($cartItems as $cartItem)
        <li>{{ $cartItem->product->name }} - Quantity: {{ $cartItem->quantity }}</li>
    @endforeach
</ul> 

<p>Total Amount: {{ $order->total }}</p>

<p>Thank you for your purchase!</p>