<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Order;
use App\Models\Cart; 
use App\Http\Controllers\Session;// Adjust this if your Cart model is in a different namespace

class RazorpayController extends Controller
{
    /**
     * Handle Razorpay payment callback.
     *
     * @param  \Illuminate\Http\Request  \
     * @return \Illuminate\Http\Response
     */
 
     public function handlePaymentCallback(Request $request)
     {
         $razorpay = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
 
         $paymentId = $request->input('razorpay_payment_id');

         $orderId = $request->input('razorpay_order_id');
     
         $signature = $request->input('razorpay_signature');
 
         $razorpayOrder = $razorpay->order->fetch($orderId);
 
         // Verify the payment signature
         $attributes = [
             'razorpay_order_id' => $razorpayOrder->id,
             'razorpay_payment_id' => $paymentId,
             'razorpay_signature' => $signature,
         ];
 
         try {
            $razorpay->utility->verifyPaymentSignature($attributes);
            // Payment success

            // Update order status as per your logic
            $order = Order::where('id', $razorpayOrder->receipt)->update(['status' => 'processed']);


            // Clear the cart for authenticated users
            if ($order->customer_id) {
                Cart::where('customer_id', $order->customer_id)->delete();
            }

            session()->get('cart', []);
            session()->forget('cart');
            return response()->view('thank.you.page', ['success' => 'Payment successful! Your order is complete.']);
        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            // Handle signature verification failure
            return response()->view('order.failed', ['error' => 'Payment failed. Signature verification error.']);
        }
    }
}