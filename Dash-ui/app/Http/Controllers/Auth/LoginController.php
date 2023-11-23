<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Product;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->middleware('guest:admin')->except('logout');
            $this->middleware('guest:writer')->except('logout');
        }

        public function showAdminLoginForm()
        {
            return view('auth.login', ['url' => 'admin']);
        }
        public function showCustomerLoginForm()
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
        
            return view('auth.customerlogin', ['url' => 'customer', 'wishlistCount' => $wishlistCount, 'cartCount' => $cartCount, 'cartItems' => $cartItems, 'cartTotal' => $cartTotal]);
        }
        
        
    
        public function adminLogin(Request $request)
        {
            $this->validate($request, [
                'email'   => 'required|email',
                'password' => 'required|min:6'
            ]);
            //dd($request);
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
               // $userId = auth()->user()->id;
             //dd('here');
                return redirect()->route('dashboard');
            }
            return back()->withInput($request->only('email', 'remember'));
        }
        public function customerLogin(Request $request)
        {
            //dd($request);
            $this->validate($request, [
                'email'   => 'required|email',
                'password' => 'required|min:6'
            ]);
            
            if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
               // $userId = auth()->user()->id;
             // dd('here');
             return redirect('/');
            }
            return back()->withInput($request->only('email', 'remember'));
        }
        public function showWriterLoginForm()
        {
            return view('auth.login', ['url' => 'writer']);
        }
    
        public function writerLogin(Request $request)
        {
            $this->validate($request, [
                'email'   => 'required|email',
                'password' => 'required|min:6'
            ]);
    
            if (Auth::guard('writer')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
    
                return redirect()->intended('/writer');
            }
            return back()->withInput($request->only('email', 'remember'));
        }

        public function logout(Request $request)
    {
        Auth::logout();
        Auth::guard('admin')->logout();
        Auth::guard('writer')->logout();
        

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    public function logoutcust(Request $request)
    {
        Auth::logout();
        Auth::guard('customer')->logout();
        
        

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    
    

}
