<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromotionalBanner;
use Illuminate\Support\Facades\Auth;

class PromotionalBannerController extends Controller
{
    public function show()
    {
        if (!Auth::guard('admin')->check()) {
            
            return redirect()->route('login'); 
        }

        $user = Auth::guard('admin')->user();
        $promotionalbanners = PromotionalBanner::all(); 
    
        return view('promotionalbanners.show', compact('user','promotionalbanners'));
    }
    
    public function add()
    {
        if (!Auth::guard('admin')->check()) {
            
            return redirect()->route('login'); 
        }
        $user = Auth::guard('admin')->user();
      
        return view('promotionalbanners.add',compact('user'));
    }

    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'title' => 'required|string|max:255',

        'description' => 'required|string|max:255',
        'target_url' => 'required|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);


    $imagePath = $request->file('image')->store('promotionalbanner_images', 'public');


    PromotionalBanner::create([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
       
        'target_url' => $request->input('target_url'),
        'image' => $imagePath,
    ]);

    return redirect()->route('promotionalbanners.show')->with('success', 'Promotional banner added successfully');
}

public function edit($id)
{
    if (!Auth::guard('admin')->check()) {
            
        return redirect()->route('login'); 
    }
    $user = Auth::guard('admin')->user();
    $promotionalbanner = PromotionalBanner::find($id);
    return view('promotionalbanners.edit', compact('user','promotionalbanner'));
}

public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
    
            'description' => 'required|string|max:255',
            'target_url' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // adjust mime types and max size as needed
        ]);

        $promotionalbanner = PromotionalBanner::findOrFail($id);

        $promotionalbanner->title = $request->input('title');
        $promotionalbanner->description = $request->input('description');
        
        $promotionalbanner->target_url = $request->input('target_url');


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('promotionalbanner_images', 'public');
            $promotionalbanner->image = $imagePath;
        }

        $promotionalbanner->save();

        return redirect()->route('promotionalbanners.show')->with('success', 'Promotional banner updated successfully');
    }
    public function destroy($id)
{

    $promotionalbanner = PromotionalBanner::findOrFail($id);

    // Delete the testimonial
    $promotionalbanner->delete();

    return response()->json(['message' => 'Promotional bannere deleted successfully']);
}
}
