<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Product;
class CustomResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/home'; // Customize the redirection URL after password reset

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Show the password reset form for customers
    public function showResetForm(Request $request, $key, $token)
    {
        $wishlistCount = 0; // Initialize with 0
        $cartCount = 0; // Initialize with 0
        $cartItems = []; // Initialize the $cartItems array
        $cartTotal = 0; // Initialize the $cartTotal
    
        if (auth()->guard('customer')->check()) {
            // Fetch the wishlist count
            $wishlistItems = Wishlist::where('customer_id', auth()->guard('customer')->id())->get();
            $wishlistCount = $wishlistItems->count();
    
            // Fetch the cart count
            $customer = auth()->guard('customer')->user();
            $cartItems = Cart::where('customer_id', $customer->id)
                ->with('product.category') // Eager load the product and category
                ->get();
            $cartCount = $cartItems->count();
    
            // Calculate the cart total
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
    
                // Check if the product exists
                if ($cartItem->product) {
                    // Access the 'price' property
                    $cartTotal += $cartItem->product->price * $cartItem->quantity;
                }
            }
        } else {
            // If the customer is not authenticated, retrieve cart from session
            $sessionCart = session('cart', []);
    
            foreach ($sessionCart as $productId => $quantity) {
                // Retrieve product details and calculate total
                $product = Product::find($productId);
                if ($product) {
                    $cartItems[] = (object)['product' => $product, 'quantity' => $quantity];
                    $cartTotal += $product->price * $quantity;
                }
            }
    
            // Set cart count based on session data
            $cartCount = count($sessionCart);
        }
    
        return view('auth.passwords.resetcust')->with([
            'token' => $token,
            'email' => $request->email,
            'wishlistCount' => $wishlistCount,
            'cartCount' => $cartCount,
            'cartItems' => $cartItems, // Pass the cart items
            'cartTotal' => $cartTotal, // Pass the cart total
        ]);
    }
    
    // Define the broker for password resets (in this case, 'customers')
    protected function broker()
    {
        return Password::broker('customers');
    }

    // Logic for resetting the password for customers
    public function resets(Request $request)
    {
       // dd($request);
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        $tokenData = DB::table('password_resets_customers')
        ->where('token', $request->token)->first();
        // $response = $this->broker()->reset(
        //     $this->credentials($request),
        //     function ($customer, $password) { 
        //         $this->resetPassword($customer, $password);
        //     }
        // );
        if (!$tokenData) return back()->withInput($request->only('email'))->withErrors(['email' => 'Invalid Token']);;
        $customer = Customer::where('email', $tokenData->email)->first();
        if (!$customer) return back()->withInput($request->only('email'))->withErrors(['email' => 'Email Not Found']);;;
        $customer->password = \Hash::make($request->password);
        $customer->update(); //or $user->save();
        DB::table('password_resets_customers')->where('email', $customer->email)
        ->delete();
        return redirect()->route('login.customer');
    }
    protected function resetPassword($customer, $password)
    {
       
        $customer->password = Hash::make($password); // Use the Hash facade to securely hash the new password.
    //dd($customer->password);
        // Check if the 'token' attribute exists in the customer model
        if ($customer->offsetExists('token')) {
            $customer->token = null; // Clear the reset token.
        }
    
        $customer->save();
    }
    
}
