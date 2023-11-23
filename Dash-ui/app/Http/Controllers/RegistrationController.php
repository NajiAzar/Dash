<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('registration');
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email_id' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' rule to match password and password_confirmation
        ]);
    }
    public function registration(Request $request)
{
    // Validate the form data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
       
        'email_id' => 'required|email|unique:customers',
        'phone' => ['required', 'string', 'max:255', 'regex:/^\d{10}$/'],

        'password' => 'required|string|min:8|confirmed',
    ]);

    // Create a new customer
    $customer = new Customer;
    $customer->name = $validatedData['name'];
 
    $customer->email_id = $validatedData['email_id'];
    $customer->phone = $validatedData['phone'];
    $customer->password = bcrypt($validatedData['password']);

    // Save the customer to the database
    $customer->save();
    Auth::guard('web')->login($customer);
    // Optionally, you can authenticate the customer here if needed.

    return redirect()->route('frontend.home');// Redirect to the home page or wherever you want after successful registration.
}
    
}
