<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Product;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    public function showResetForm(Request $request, $token = null){
        return view('auth.passwords.reset',[
            'title' => 'Reset Password',
            'passwordUpdateRoute' => 'password.update',
            'token' => $token,
        ]);
    }
//     public function showResetlinkForm()
//     {
//         $wishlistCount = 0; // Initialize with 0
//         $cartCount = 0; // Initialize with 0
//         $cartItems = []; // Initialize the $cartItems array
//         $cartTotal = 0; // Initialize the $cartTotal
    
//         if (auth()->guard('customer')->check()) {
//             // Fetch the wishlist count
//             $wishlistItems = Wishlist::where('customer_id', auth()->guard('customer')->id())->get();
//             $wishlistCount = $wishlistItems->count();
    
//             // Fetch the cart count
//             $customer = auth()->guard('customer')->user();
//             $cartItems = Cart::where('customer_id', $customer->id)
//                 ->with('product.category') // Eager load the product and category
//                 ->get();
//             $cartCount = $cartItems->count();
    
//             // Calculate the cart total
//             foreach ($cartItems as $cartItem) {
//                 $product = $cartItem->product;
    
//                 // Check if the product exists
//                 if ($cartItem->product) {
//                     // Access the 'price' property
//                     $cartTotal += $cartItem->product->price * $cartItem->quantity;
//                 }
//             }
//         } else {
//             // If the customer is not authenticated, retrieve cart from session
//             $sessionCart = session('cart', []);
    
//             foreach ($sessionCart as $productId => $quantity) {
//                 // Retrieve product details and calculate total
//                 $product = Product::find($productId);
//                 if ($product) {
//                     $cartItems[] = (object)['product' => $product, 'quantity' => $quantity];
//                     $cartTotal += $product->price * $quantity;
//                 }
//             }
    
//             // Set cart count based on session data
//             $cartCount = count($sessionCart);
//         }
    
//         return view('auth.passwords.custemail', ['wishlistCount' => $wishlistCount, 'cartCount' => $cartCount, 'cartItems' => $cartItems, 'cartTotal' => $cartTotal]);
//     }
    

// public function showResetForm(Request $request, $token)
// {
//     $wishlistCount = 0; // Initialize with 0
//     $cartCount = 0; // Initialize with 0
//     $cartItems = []; // Initialize the $cartItems array
//     $cartTotal = 0; // Initialize the $cartTotal

//     if (auth()->guard('customer')->check()) {
//         // Fetch the wishlist count
//         $wishlistItems = Wishlist::where('customer_id', auth()->guard('customer')->id())->get();
//         $wishlistCount = $wishlistItems->count();

//         // Fetch the cart count
//         $customer = auth()->guard('customer')->user();
//         $cartItems = Cart::where('customer_id', $customer->id)
//             ->with('product.category') // Eager load the product and category
//             ->get();
//         $cartCount = $cartItems->count();

//         // Calculate the cart total
//         foreach ($cartItems as $cartItem) {
//             $product = $cartItem->product;

//             // Check if the product exists
//             if ($cartItem->product) {
//                 // Access the 'price' property
//                 $cartTotal += $cartItem->product->price * $cartItem->quantity;
//             }
//         }
//     } else {
//         // If the customer is not authenticated, retrieve cart from session
//         $sessionCart = session('cart', []);

//         foreach ($sessionCart as $productId => $quantity) {
//             // Retrieve product details and calculate total
//             $product = Product::find($productId);
//             if ($product) {
//                 $cartItems[] = (object)['product' => $product, 'quantity' => $quantity];
//                 $cartTotal += $product->price * $quantity;
//             }
//         }

//         // Set cart count based on session data
//         $cartCount = count($sessionCart);
//     }

//     return view('auth.passwords.resetpassword')->with([
//         'token' => $token,
//         'email' => $request->email,
//         'wishlistCount' => $wishlistCount,
//         'cartCount' => $cartCount,
//         'cartItems' => $cartItems, // Pass the cart items
//         'cartTotal' => $cartTotal, // Pass the cart total
//     ]);
// }


    
}
