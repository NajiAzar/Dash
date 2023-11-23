<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Brand;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Facades\Input;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::all();
        $categories = Category::all();
        $itemsPerPage = 9;
        $page = $request->query('page', 1);
        $category = $request->query('category', null);
        $brand = $request->query('brand', null);
    
        $query = Product::select('products.*');
    
        $wishlistItems = Wishlist::where('customer_id', auth()->guard('customer')->id())->get();
        $wishlistCount = $wishlistItems->count();
    
        // Fetch the cart count and cart items for the user
        $cartItems = [];
        $cartCount = 0;
        $cartTotal = 0; // Initialize cartTotal
    
        if (auth()->guard('customer')->check()) {
            $customer = auth()->guard('customer')->user();
            $cartItems = Cart::where('customer_id', $customer->id)
                ->with('product.category') // Eager load the product and category
                ->get();
            $cartCount = $cartItems->count();
            // Calculate cartTotal
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
    
                // Check if the product exists
                if ($product) {
                    // Calculate the total cost for each cart item (e.g., product price * quantity)
                    $itemTotal = $product->price * $cartItem->quantity;
                    $cartTotal += $itemTotal;
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
    
        if ($category) {
            $query->where('category_id', $category);
        }
    
        if ($brand) {
            $query->where('brand_id', $brand);
        }
    
        $selectedSortOption = $request->query('sort', 'newest');
    
        switch ($selectedSortOption) {
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->latest();
                break;
        }
    
        $products = $query->paginate($itemsPerPage);
        $productCount = $query->count();
    
        return view('frontend.products.index', compact('products', 'categories', 'brands', 'brand', 'selectedSortOption', 'category', 'productCount', 'wishlistCount', 'cartCount', 'cartItems', 'cartTotal'));
    }
    
    
    
    public function filterByPrice(Request $request)
{
    $minPrice = $request->input('minPrice');
    $maxPrice = $request->input('maxPrice');

    // Query products within the specified price range
    $products = Product::whereBetween('price', [$minPrice, $maxPrice])->get();

    // You can add additional logic here if needed

    return view('frontend.products.index', compact('products', 'categories', 'brands', 'brand', 'selectedSortOption', 'category', 'productCount'));
}
    public function subxCategoryProducts(Request $request, $subcategory_id)
    {
        // Fetch products based on the provided subcategory_id
        $itemsPerPage = 8;
        $page = $request->query('page', 1);
        
        // Start with a base query
        $query = $subcategory_id ? Product::where('category_id', $subcategory_id) : Product::query();
    
        // Get the sort option
        $sortOption = $request->query('sort', 'latest');
    
        // Apply sorting logic to the query
        switch ($sortOption) {
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();  // Assuming 'created_at' is your timestamp column
                break;
            default:
                $query->latest();  // Default to sorting by the latest
                break;
        }
    
        // Fetch products with pagination
        $products = $query->paginate($itemsPerPage);
        
        // Get the product count based on the query
        $productCount = $query->count();
        
        // Pass the products, subcategory_id, sortOption, and productCount to the view
        return view('frontend.products.index', compact('products', 'subcategory_id', 'sortOption', 'productCount'));
    }
    
    
public function sort(Request $request)
{
    $sortOption = $request->query('sort');
    return redirect('/products?sort=' . $sortOption);
}

public function filter(Request $request)
{
    $category = $request->query('category');
    return redirect('/products?category=' . $category);
}


public function show($id)
{
    // Fetch the product details by its ID
    $product = Product::findOrFail($id);

    // Get associated product images
    $images = $product->images;

    // Initialize the wishlist count, cart count, and flags for product in the wishlist and cart
    $wishlistCount = 0;
    $cartCount = 0;
    $cartTotal = 0; // Initialize the $cartTotal variable
    $isInWishlist = false;
    $isInCart = false;
    $wishlistItem = null; // Initialize $wishlistItem to null
    $cartItems = []; // Initialize an array for cart items

    // Check if the customer is authenticated (assumes "customer" guard)
    if (auth()->guard('customer')->check()) {
        $customer = auth()->guard('customer')->user();

        // Check if the product is in the customer's wishlist
        $wishlistItem = Wishlist::where('customer_id', $customer->id)
            ->where('product_id', $product->id)
            ->first();

        if ($wishlistItem) {
            $isInWishlist = true; // Product is in the wishlist
        }

        // Get the wishlist count for the user
        $wishlistItems = Wishlist::where('customer_id', $customer->id)->get();
        $wishlistCount = $wishlistItems->count();

        // Fetch the cart items for the user
        $cartItems = Cart::where('customer_id', $customer->id)->get();
        $cartCount = $cartItems->count();

        // Calculate the cart total
        foreach ($cartItems as $cartItem) {
            $cartTotal += $cartItem->product->price * $cartItem->quantity;
        }

        // Check if the product is in the cart
        foreach ($cartItems as $cartItem) {
            if ($cartItem->product_id == $product->id) {
                $isInCart = true;
                break;
            }
        }
    } else {
        // If the customer is not authenticated, retrieve cart from session
        $sessionCart = session('cart', []);

        foreach ($sessionCart as $productId => $quantity) {
            // Retrieve product details and calculate total
            $productInSession = Product::find($productId);
            if ($productInSession) {
                $cartItems[] = (object)['product' => $productInSession, 'quantity' => $quantity];
                $cartTotal += $productInSession->price * $quantity;
            }
        }

        // Set cart count based on session data
        $cartCount = count($sessionCart);
    }
    $similarProducts = Product::where('category_id', $product->category_id) 
    ->where('id', '!=', $id) 
    ->limit(4)
    ->get();
  
    return view('frontend.products.product_detail', compact('product','similarProducts', 'images', 'wishlistCount', 'cartCount', 'isInWishlist', 'isInCart', 'wishlistItem', 'cartItems', 'cartTotal'));
}
public function search(Request $request)
{
    $query = $request->input('query');
    $brands = Brand::all();
    $categories = Category::all();
    $selectedSortOption = $request->query('sort', 'newest');
    $itemsPerPage = 8;
        $page = $request->query('page', 1);
    
    
   
 
    $products = Product::where('name', 'like', "%$query%")
                     ->orWhere('description', 'like', "%$query%")
                     ->get();


                     
                     $productCount = $products->count();
                     switch ($selectedSortOption) {
                        case 'price_low_high':
                            $query->orderBy('price', 'asc');
                            break;
                        case 'price_high_low':
                            $query->orderBy('price', 'desc');
                            break;
                  
                    }
                    // $products = $query->paginate($itemsPerPage);
                     // You can pass $results to the view or handle as needed
    return view('search-results', ['products' => $products,'productCount'=>$productCount, 'categories'=>$categories, 'brands'=>$brands, 'selectedSortOption'=>$selectedSortOption]);
}


}
