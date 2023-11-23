<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Product;

class CartViewComposer
{
    public function compose(View $view)
    {
        $wishlistItems = Wishlist::where('customer_id', auth()->guard('customer')->id())->get();
        $wishlistCount = $wishlistItems->count();

        $cartItems = [];
        $cartTotal = 0;
        $cartCount = 0;

        // Check if the customer is authenticated
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            $cartItems = Cart::where('customer_id', $customer->id)
                ->with('product.category')
                ->get();
            $cartCount = $cartItems->count();

            // Calculate the cart total
            foreach ($cartItems as $cartItem) {
                if ($cartItem->product) {
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

        // Pass data to the view
        $view->with('wishlistItems', $wishlistItems)
             ->with('wishlistCount', $wishlistCount)
             ->with('cartItems', $cartItems)
             ->with('cartTotal', $cartTotal)
             ->with('cartCount', $cartCount);
    }
}
