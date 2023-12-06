<?php

// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Feedback;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function trackOrder(Request $request, $orderId = null)
    {
        // if ($orderId === null) {

        //     return response()->json(['status' => 'error', 'message' => 'please track your order using order number'], 400);
        // }
        if ($request->ajax()) {
            $request->validate([
                'order_number' => 'required|exists:orders,id',
            ]);
            $order = Order::with('shippingAddress', 'orderDetails')->find($request->input('order_number'));
            if ($order) {
                return response()->json(['status' => 'success', 'order' => $order]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }
        } else {
            $request->validate([
                'order_number' => 'required|exists:orders,id',
            ]);

            $order = Order::with('shippingAddress', 'orderDetails')->find($request->input('order_number'));
            return view('trackorder.trackorder-details', ['order' => $order]);
        }
    }

    public function show()
    {
        if (!Auth::guard('admin')->check()) {
            
            return redirect()->route('login'); 
        }
        $orders = Order::latest()->paginate(10);

        $user = Auth::guard('admin')->user();

        return view('order.show', compact('user', 'orders'));
    }
    public function view($id)
    {
        if (!Auth::guard('admin')->check()) {
            
            return redirect()->route('login'); 
        }
        $user = Auth::guard('admin')->user();
        $order = Order::find($id);
        $orderFeedbacks = Feedback::where('order_id', $id)->get();

        return view('order.view', compact('user', 'order','orderFeedbacks'));
    }

    public function updateStatus(Request $request)
    {
        $orderId = $request->input('order_id');
        $newStatus = $request->input('status');
        $order = Order::find($orderId);
        if ($order) {
            if ($newStatus === 'cancelled') {
                // Set the 'cancelled_date' if the order is not already cancelled
                if ($order->status !== 'cancelled') {
                    $order->cancelled_date = now();
                }
            }
            $order->status = $newStatus;
            $order->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
    public function getStatus(Request $request, $order_id)
    {
        $order = Order::find($order_id);

        if ($order) {
            return response()->json(['success' => true, 'status' => $order->status]);
        } else {
            return response()->json(['success' => false, 'status' => null]);
        }
    }
    public function cancelOrder($orderId)
{
   // dd('orderid '.$orderId);
    $order = Order::find($orderId);

    if (!$order || $order->customers_id != auth()->guard('customer')->user()->id) {
        return redirect()->route('/')->with('error', 'Unable to cancel the order.');
    }

    if ($order->status == 'delivered') {
        return redirect()->route('/')->with('error', 'Order delivered. Unable to cancel.');
    }

    $order->status = 'cancelled';
    $order->cancelled_date = now();
    $order->save();

    return redirect('/')->with('success', 'Your order has been cancelled successfully.');
}

public function processCancelOrder($orderId)
{
    $order = Order::find($orderId);

    // Check if the order exists
    if (!$order) {
        return redirect()->route('frontend.home')->with('error', 'Unable to cancel the order.');
    }

   
    $order->status = 'cancelled';
    $order->cancelled_date = now();
    $order->save();

    return redirect()->route('frontend.home')->with('success', 'Your order has been cancelled successfully.');
}
public function showVerificationPage($orderId)
{
    $order = Order::find($orderId);
   // dd($order->shippingAddress->email_address);
    return view('order.verification',['order' => $order]);
}


public function verifyOrderemail(Request $request, $orderId)
{
   // dd($request->all());
    // Retrieve order based on $orderId
    $order = Order::find($orderId);

    // Check if the order exists
    if (!$order) {
        // Handle the case where the order is not found
        return redirect()->route('verifyOrderPage', ['orderId' => $orderId])->with('error', 'Order not found.');
    }
    //dd($order->shippingAddress->email_address);
    // Check if the provided email address matches the order's shipping address
    $emailAddress = $request->input('emailAddress');
   
    if ($order->shippingAddress->email_address !== $emailAddress) {
        // Handle the case where the email address doesn't match
        return redirect()->route('verifyOrderPage', ['orderId' => $orderId])->with('error', 'Invalid email address for the order.');
    }

 
    return redirect()->route('cancelorderDetails', ['orderId' => $orderId])->with('emailAddress', $emailAddress);
}

public function cancelorderDetails($orderId)
{
    $order = Order::find($orderId);

    if (!$order) {
        return redirect()->route('/')->with('error', 'Order not found.');
    }

    // Add logic to cancel the order (update order status, etc.)
    $order->status = 'cancelled';
    $order->cancelled_date = now(); // Set the current date and time
    $order->save();

    return redirect()->route('VerifiedorderDetails', ['orderId' => $orderId])->with('success', 'Email Verified successfully.');
}
public function showOrderDetails($orderId)
{
    $order = Order::find($orderId);

    if (!$order) {
        return redirect()->route('/')->with('error', 'Order not found.');
    }

    return view('order.order-details-verified', ['order' => $order]);
}

public function filterOrders(Request $request)
{
    $orderNumber = $request->input('order_number');
    $status = $request->input('status');
    $paymentMethod = $request->input('payment_method');
    
    $user = Auth::guard('admin')->user();
    $orders = Order::query();

    if ($orderNumber) {
        $orders->where('id', $orderNumber);
    }

    if ($status !== null) {
        if ($status === 'pending') {
            $orders->whereIn('status', ['pending', '0']);
        } else {
            $orders->where('status', $status);
        }
    }

    if ($paymentMethod !== null) {
        $orders->where('payment_method', $paymentMethod);
    }

    $filteredOrders = $orders->latest()->paginate(10);

    return view('order.show', ['orders' => $filteredOrders, 'user' => $user]);
}


public function feedback($orderNumber)
{
    // Retrieve order details based on $orderNumber
    $order = Order::where('id', $orderNumber)->first();

    // Add logic to handle feedback

    return view('feedback.form', ['order' => $order]);
}


}


