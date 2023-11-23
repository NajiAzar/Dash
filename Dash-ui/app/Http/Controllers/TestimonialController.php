<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    
    public function show()
    {
        
        $user = Auth::guard('admin')->user();
        $testimonials = Testimonial::all(); // Fetch all testimonials
    
        return view('testimonials.show', compact('user','testimonials'));
    }
    
    public function add()
    {
        $user = Auth::guard('admin')->user();
      
        return view('testimonials.add',compact('user'));
    }

    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'company' => 'required|string|max:255',
        'designation' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // adjust mime types and max size as needed
    ]);

    // Handle image upload
    $imagePath = $request->file('image')->store('testimonial_images', 'public');

    // Create a new Testimonial and store in the database
    Testimonial::create([
        'name' => $request->input('name'),
        'company' => $request->input('company'),
        'designation' => $request->input('designation'),
        'content' => $request->input('content'),
        'image' => $imagePath,
    ]);

    return redirect()->route('testimonials.show')->with('success', 'Testimonial added successfully');
}

public function edit($id)
{
    $user = Auth::guard('admin')->user();
    $testimonial = Testimonial::find($id);
    return view('testimonials.edit', compact('user','testimonial'));
}

public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:800',
            'content' => 'required|string',
        ]);

        $testimonial = Testimonial::findOrFail($id);

        // Update testimonial attributes
        $testimonial->name = $request->input('name');
        $testimonial->company = $request->input('company');
        $testimonial->designation = $request->input('designation');
        $testimonial->content = $request->input('content');

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonial_images', 'public');
            $testimonial->image = $imagePath;
        }

        $testimonial->save();

        return redirect()->route('testimonials.show')->with('success', 'Testimonial updated successfully');
    }
    public function destroy($id)
{
    // Find the testimonial
    $testimonial = Testimonial::findOrFail($id);

    // Delete the testimonial
    $testimonial->delete();

    return response()->json(['message' => 'Testimonial deleted successfully']);
}



}
