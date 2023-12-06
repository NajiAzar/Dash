<?php

namespace App\Http\Controllers;

use App\Admin; // Replace with your actual Admin model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Order;


class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth'); // Apply 'auth' middleware to all methods in this controller
    // }
    public function dashboard()
    {
        if (!Auth::guard('admin')->check()) {
            
            return redirect()->route('login'); 
        }
        $user = Auth::guard('admin')->user();
        $monthlyRevenue = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total) as revenue')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->pluck('revenue', 'month');
    
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $totalOrderValue = Order::sum('total');
        $cancelledOrdersValue = Order::where('status', 'cancelled')->sum('total');
 
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $deliveredOrdersValue = Order::where('status', 'delivered')->sum('total');
        $recentOrders = Order::latest()->take(5)->get();
        return view('admin.dashboard',compact('user','totalProducts','totalOrders','cancelledOrders','deliveredOrders','totalOrderValue','cancelledOrdersValue','deliveredOrdersValue','recentOrders','monthlyRevenue'));
    }
    public function showadmin()
    {
        if (!Auth::guard('admin')->check()) {
            
            return redirect()->route('login'); 
        }
        $admins = Admin::paginate(10);
        $user = Auth::guard('admin')->user();
    
        return view('admin.showadmin', compact('user', 'admins'));
    }
    

    public function showform()
    {
        if (!Auth::guard('admin')->check()) {
            
            return redirect()->route('login'); 
        }
        $user = Auth::guard('admin')->user();
      
        return view('admin.addadmin',compact('user'));
    }

    public function store(Request $request)
    {

        // Validate the form data
        $request->validate([
            'firstName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,NULL,id', 
            'password' => 'required|min:6|confirmed',
        ]);

        // Create a new admin
        $admin = Admin::create([
            'name' => $request->input('firstName'),
            'email' => $request->input('email'),
            'password' => Hash::make($request['password']),
            // Add other fields as needed
        ]);

        // Optionally, you can redirect the user to a page indicating success
        return redirect()->route('showadmin')->with('success', 'Admin created successfully');
    }

    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            
            return redirect()->route('login'); 
        }
        $user = Auth::guard('admin')->user();
        $admin = Admin::find($id);
        return view('admin.editadmin', compact('user','admin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $id,
        ]);

        $admin = Admin::find($id);
        $admin->name = $request->input('firstName');
        $admin->email = $request->input('email');
        $admin->save();

        return redirect()->route('showadmin')->with('success', 'Admin updated successfully');
    }

   

    public function destroy($id)
{
    $admin = Admin::find($id);
    if (!$admin) {
        return redirect()->route('showadmin')->with('error', 'Admin not found.');
    }

    // Delete the admin
    $admin->delete();

    return redirect()->route('showadmin')->with('success', 'Admin deleted successfully.');
}
}
