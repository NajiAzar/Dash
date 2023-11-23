<?php
   
    namespace App\Http\Controllers\Auth;
    use App\User;
    use App\Admin;
    use App\Writer;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Foundation\Auth\RegistersUsers;
    use App\Models\Customer;
    use App\Models\Wishlist;
    use App\Models\Cart;
    use App\Models\Product;
    
    use Illuminate\Http\Request;

    class RegisterController extends Controller
    {
        use RegistersUsers; 
        public function __construct()
        {
            $this->middleware('guest');
            $this->middleware('guest:admin');
            $this->middleware('guest:writer');
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
        
        
    
        public function showCustomerRegisterForm()
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
        
            return view('auth.customerregister', ['wishlistCount' => $wishlistCount, 'cartCount' => $cartCount, 'cartItems' => $cartItems, 'cartTotal' => $cartTotal]);
        }
        

        
    
        public function showWriterRegisterForm()
        {
            return view('auth.register', ['url' => 'writer']);
        }
        protected function validator(array $data)
        {
            return Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
              
                'phone' => ['required', 'string', 'max:255'],
            ]);
        }
        public function showAdminRegisterForm()
        {
            return view('auth.register', ['url' => 'admin']);
        }
    
        public function createCustomer(Request $request)
        {
            // Validate the request data
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers',
                'phone' => 'required|string|max:15',
                'password' => 'required|string|min:8|confirmed',
            ]);
        
            // Create a new customer
            $customer = Customer::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'password' => Hash::make($request['password']),
            ]);
        
            // Redirect the user after registration
            return redirect()->route('customerLogin');
        }
        
            
    protected function createAdmin(Request $request)
    {
        $this->validator($request->all())->validate();
        $admin = Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->intended('login/admin');
    }
    protected function createWriter(Request $request)
    {
        $this->validator($request->all())->validate();
        $writer = Writer::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->intended('login/writer');
    }
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
