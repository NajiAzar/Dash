<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; 
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;  
use App\Models\OrderDetail;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function showCheckoutForm()
    {
        
        return view('checkout.form');
    }
    

    public function processOrder(Request $request)
    {
        // Validation logic (adjust as needed)
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'postcode' => 'required|digits:6|numeric',
            'city' => 'required',
            'state' => 'required',
            'phone_number' => 'required|digits:10|numeric',
            'email_address' => 'required|email',
            'shipping_address' => 'required',
            'shipping_postcode' => 'required|digits:6|numeric',
            'shipping_city' => 'required',
            'shipping_state' => 'required',
            'payment_method' => 'required',
        ]);
    
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
           
        } else {
            $customer = null; 
        }
    
        $cartItems = [];

        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            $cartItems = Cart::where('customer_id', $customer->id)->get();
        } else {
            $sessionCart = Session::get('cart', []);
        
            foreach ($sessionCart as $productId => $quantity) {
                $product = Product::find($productId);
        
                if ($product) {
                    $cartItem = new Cart([
                        'product' => $product,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                    ]);
        
                    $cartItems[] = $cartItem;
                }
            }
        }
        
        $totalAmount = 0;
        
        foreach ($cartItems as $cartItem) {
            $totalAmount += $cartItem->product->price * $cartItem->quantity;
        }
    
        $billingAddress = Address::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'address' => $request->input('address'),
            'postcode' => $request->input('postcode'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'phone_number' => $request->input('phone_number'),
            'email_address' => $request->input('email_address'),
        ]);
  
        $shippingAddress = Address::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'address' => $request->input('shipping_address'),
            'postcode' => $request->input('shipping_postcode'),
            'city' => $request->input('shipping_city'),
            'state' => $request->input('shipping_state'),
            'phone_number' => $request->input('phone_number'),
            'email_address' => $request->input('email_address'),
        ]);
    
     
        $order = Order::create([
            'customers_id' => $customer ? $customer->id : null,
            'total' => $totalAmount,
            'billing_address_id' => $billingAddress->id,
            'shipping_address_id' => $shippingAddress->id,
            'payment_method' => $request->input('payment_method'),
        ]);
    //dd($order);
        // Save order details
        foreach ($cartItems as $cartItem) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product->id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
        }
    
        // Send email notification
        $this->sendOrderConfirmationEmail($customer, $order, $cartItems, $request);
    
        // Clear the cart for authenticated users
        if ($customer) {
            Cart::where('customer_id', $customer->id)->delete();
        }
    
        Session::forget('cart');
    
        return $this->thankYouPage($order, $cartItems);
    }
    
    protected function sendOrderConfirmationEmail($customer, $order, $cartItems, $request)
    {
        $emailData = [
            'customer' => $customer,
            'order' => $order,
            'cartItems' => $cartItems,
        ];
    
        // Get the email address
        $emailAddress = $customer ? $customer->email : $order->billingAddress->email_address;
    
        // Create a default customer instance for unauthenticated users
        $defaultCustomer = new Customer([
            'email' => $request->input('email_address'), // Replace with the appropriate input field
        ]);
    
        // Adjust the email template and subject based on your requirements
        Mail::to($emailAddress)->send(new OrderConfirmationMail($customer ?? $defaultCustomer, $order, $cartItems));
    }
    
    
    

    public function thankYouPage($order, $cartItems)
{
   
    return view('thank-you', compact('order', 'cartItems'));
}
}
