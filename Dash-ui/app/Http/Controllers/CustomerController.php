<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 

class CustomerController extends Controller
{

    public function editProfile()
    {
        $customer = auth()->guard('customer')->user();
        return view('customer.edit-profile', compact('customer'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);
        $customer = auth()->guard('customer')->user();
        $customer->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);
        return redirect()->route('customerLogin')->with('success', 'Profile updated successfully.');
    }

    public function orderDetails()
    {
        $orders = Order::with('shippingAddress', 'orderDetails')
            ->where('customers_id', Auth::guard('customer')->id())
            ->orderBy('id', 'desc')
            ->get();
    
        return view('customer.order-details', compact('orders'));
    }
    public function changepassword()
    {
        $customer = auth()->guard('customer')->user();   
        return view('customer.changepassword',compact('customer'));
    }
    public function updatePassword(Request $request)
    {
        $user = auth()->guard('customer')->user();
    
        // Validate the request data
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        return $fail('The current password is incorrect.');
                    }
                },
            ],
            'new_password' => 'required|min:8|different:current_password',
            'confirm_password' => 'required|same:new_password',
        ]);
    
        // Update the password in the database
        $user->update([
            'password' => Hash::make($request->input('new_password')),
        ]);
    
        // Set success message in the session
        $request->session()->flash('success', 'Password updated successfully.');
      
       return redirect()->back();
    }
    
}