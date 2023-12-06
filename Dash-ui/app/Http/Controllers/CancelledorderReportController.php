<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Exports\CancelledordersExport;
use Maatwebsite\Excel\Facades\Excel; 


class CancelledorderReportController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
    
        $user = Auth::guard('admin')->user();
        $request->validate([
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
        ], [
            'endDate.after_or_equal' => 'The end date must be equal to or after the start date.',
        ]);
    
    
        // If validation fails, redirect back with validation errors
      
        $query = Order::where('status', 'cancelled');
   
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->whereHas('ShippingAddress', function ($subquery) use ($keyword) {
                $subquery->where('first_name', 'like', '%' . $keyword . '%')
                         ->orWhere('last_name', 'like', '%' . $keyword . '%');
            });
        }
    
        // Apply date range filter if provided
        if ($request->filled('startDate') && $request->filled('endDate')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
    
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        if ($request->has('export')) {
            return Excel::download(new CancelledordersExport, 'cancelledorders.xlsx');
        }
        $totalcancelledorders = $query->get();
        // Paginate the results
        $cancelledorders = $query->paginate(10);
     
    
   // dd($sales);
        // Calculate net total
        $netTotal = $totalcancelledorders->sum('total');
    
        return view('cancelledorders-report', compact('cancelledorders', 'netTotal', 'user','totalcancelledorders'));
    }
}
