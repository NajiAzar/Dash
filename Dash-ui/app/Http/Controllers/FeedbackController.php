<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FeedbackController extends Controller
{
    // public function create(Request $request, $orderNumber)
    // {
    //     // Find the order
    //     $order = Order::where('order_number', $orderNumber)->firstOrFail();

    //     // Check if the order is delivered
    //     if ($order->status == 'delivered') {
    //         return view('feedback.create', ['order' => $order]);
    //     } else {
    //         return redirect()->route('orders.view', ['id' => $order->id])->with('error', 'Feedback can only be added for delivered orders.');
    //     }
    // }

    public function store(Request $request,$orderNumber)
    {
       // dd($orderNumber);
        $request->validate([
            'comment' => 'required|string|max:255',
            
        ]);

       // $orderNumber = $request->input('orderNumber');
        $comment = $request->input('comment');
//dd($comment);
        $order = Order::findOrFail($orderNumber);

        // Make sure the authenticated user is the customer who made the order
        if (Auth::guard('customer')->check() && Auth::guard('customer')->user()->id !== $order->customers_id) {
            abort(403, 'Unauthorized action.');
        }

        // Store the feedback
        $feedback = new Feedback();
        $feedback->order_id = $orderNumber;
        $feedback->customer_id = $order->customers_id;
        $feedback->comment = $comment;
        $feedback->save();

        return redirect()->back()->with('success', 'Feedback submitted successfully.');
    }
}
