<?php

// app/Http/Controllers/WishlistController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use Auth;

class WishlistController extends Controller
{
    public function add(Product $product)
    {
        //dd($product);
        
        if (Auth::guard('customer')->check()) {
          
            $customer = Auth::guard('customer')->user();
           // dd($customer);
            $wishlistItem = Wishlist::where('customer_id', $customer->id)
            
                ->where('product_id', $product->id)
                ->first();
              //dd($wishlistItem);
                
            if (!$wishlistItem) {
                // If the product is not already in the wishlist, add it
                Wishlist::create([
                    'customer_id' => $customer->id,
                    'product_id' => $product->id,
                ]);
                return response()->json(['success' => true, 'message' => 'Product added to your wishlist']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Product not added to your wishlist']);
    }

    public function index()
    {
    //     $wishlistItems = Wishlist::where('customer_id', auth()->guard('customer')->id())->get();
    // $wishlistCount = $wishlistItems->count();
    //     // Fetch the user's wishlist items and display them in the wishlist view
        if (Auth::guard('customer')->check()) {
          
            $customer = Auth::guard('customer')->user();
            $wishlistItems = Wishlist::where('customer_id', $customer->id)->get();

            return view('wishlist.index');
        } else {
            return view('wishlist.index')->with('error', 'You must be logged in to view your wishlist.');
        }
    }

    public function remove($wishlistItemId)
{
     
    // Check if the authenticated user owns the wishlist item before removing it
    if (Auth::guard('customer')->check()) {
        $wishlistItem = Wishlist::find($wishlistItemId);
    
        if ($wishlistItem && Auth::guard('customer')->user()->id === $wishlistItem->customer_id) {
            $wishlistItem->delete();
           
            return response()->json(['success' => true]);
        }
    }
    
    return response()->json(['success' => false]);
}    

}
