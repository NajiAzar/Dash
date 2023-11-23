<?php


namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use App\Mail\ResetPasswordMail;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\DB;



class CustomForgotPasswordController extends ForgotPasswordController
{
    use SendsPasswordResetEmails;

    // Make the broker() method public
    public function broker()
    {
        return Password::broker('customers');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        $customer = Customer::where('email', $request->input('email'))->first();
    
        if ($customer) {
            $token = md5($customer->email) . rand(10, 9999);
    
            // Assume reset link should expire after 1 day
            $createdDate = now();
            $expDate = $createdDate->copy()->addDay();
    
            DB::table('password_resets_customers')->insert([
                'email' => $customer->email,
                'token' => $token,
                'created_at' => $createdDate,
            ]);
    
            $link = route('password.resetform', ['key' => $customer->email, 'token' => $token]);
    //dd($link);
            // Send the password reset email
            Mail::to($customer->email)->send(new ResetPasswordMail($link));
   
            return back()->with('status', 'Password reset link sent successfully. Check your email.');
        } else {
            return back()->withErrors(['email' => 'Invalid Email Address.'])->withInput();
        }
    }
    
 
}
