<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Wishlist;
use App\Models\Cart;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    public function add(Product $product, Request $request)
    {
        // Get the quantity from the form input
        $quantity = $request->input('quantity');
    
        // Check if the user is authenticated
        if (Auth::guard('customer')->check()) {
            // User is authenticated, associate the cart with the user
            $user = Auth::guard('customer')->user();
            $cartItem = Cart::where('customer_id', $user->id)
                ->where('product_id', $product->id)
                ->first();
    
            if ($cartItem) {
                // Product is already in the cart, update the quantity
                $cartItem->quantity += $quantity ?? 1; // If quantity is null, set it to 1
                $cartItem->save();
            } else {
                // Product is not in the cart, create a new cart item
                Cart::create([
                    'customer_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity ?? 1, // If quantity is null, set it to 1
                ]);
            }
        } else {
            // User is not authenticated, store the cart in the session
            $cart = session('cart', []);
            if (isset($cart[$product->id])) {
                // Product is already in the session cart, update the quantity
                $cart[$product->id] += $quantity ?? 1; // If quantity is null, set it to 1
            } else {
                // Product is not in the session cart, add it
                $cart[$product->id] = $quantity ?? 1; // If quantity is null, set it to 1
               // dd( $cart[$product->id]);
            }
       //  dd(  session(['cart' => $cart]));
     
            session(['cart' => $cart]);
         //   dd(  session(['cart' => $cart]));
            //session()->flash('success', 'sfdasfds');
        }
       // dd(session('cart')); 
        // Set a success flash message
        session()->flash('success', 'Item added to cart');
    
        // Redirect back to the product page or the cart page
        return redirect()->back();
    }
    
    public function index()
    {
        // Get the cart items and display them in the cart view.
        // You can retrieve cart items from the database or session here.
        return view('cart.index');
    }

    public function removeFromCart(Request $request, $productId)
    {
        if ($request->ajax()) {
            if (auth()->guard('customer')->check()) {
                $customer = auth()->guard('customer')->user();
                $cartItem = Cart::where('customer_id', $customer->id)
                    ->where('product_id', $productId)
                    ->first();
    
                if ($cartItem) {
                   
                    $cartItem->delete();
                    // $newCartTotal = DB::table('carts')
                    // ->join('products', 'carts.product_id', '=', 'products.id')
                    // ->where('carts.customer_id', $customer->id)
                    // ->sum('products.price');
                    $newCartTotal = DB::table('carts')
    ->join('products', 'carts.product_id', '=', 'products.id')
    ->where('carts.customer_id', $customer->id)
    ->sum(DB::raw('products.price * carts.quantity'));
                    $cartItems = Cart::where('customer_id', $customer->id)->get();
                    $cartCount = $cartItems->count();
                    // Calculate the new cart total based on the remaining cart items
                   // $newCartTotal = $customer->cartItems()->sum('price');
                    //$newCartTotal = $customer->cartItems()->toSql();
                  //dd($newCartTotal); 
                  return response()->json([
                    'newCartTotal' => $newCartTotal,
                    'newCartCount' => $cartCount, // This should be the updated cart count
                    'message' => 'Item removed from the cart.',
                ]);
                            } else {
                    return response()->json(['error' => 'Item not found in the cart.']);
                }
            } else {
                return response()->json(['error' => 'Please log in to remove items from the cart.']);
            }
        }
    }
    
    // CartController.php
public function updateQuantity(Request $request)
{
   // dd($request);

    $productId = $request->input('product_id');
    $cartItemId = $request->input('cart_item_id');
    $newQuantity = $request->input('new_quantity');

    // Validate the request and perform any necessary checks

    // Find the cart item by ID
    $cartItem = Cart::find($cartItemId);

   
    if (!$cartItem) {
        return response()->json(['error' => 'Cart item not found']);
    }
  
    // Update the cart item's quantity in the database
    $cartItem->quantity = $newQuantity;
    //dd($cartItem->quantity);
    $cartItem->save();

    return response()->json(['success' => true]);
}

public function updateQuantityLoggedOut(Request $request)
{
    $productId = $request->input('product_id');
    $cartItemId = $request->input('cart_item_id');
    $newQuantity = $request->input('new_quantity');

    // Retrieve the current session cart
    $cart = session('cart', []);

    // Update the quantity for the specified product in the session cart
    if (isset($cart[$productId])) {
        $cart[$productId] = $newQuantity;
    }

    // Save the updated cart back to the session
    session(['cart' => $cart]);

    // Return a success response
    return response()->json(['success' => true]);
}
}