<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homeslide;
use Illuminate\Support\Facades\Auth; 

class HomeSlideController extends Controller
{
    public function show()
    {
        
        $user = Auth::guard('admin')->user();
        $homesliders = Homeslide::all(); 
    
        return view('homesliders.show', compact('user','homesliders'));
    }
    
    public function add()
    {
        $user = Auth::guard('admin')->user();
      
        return view('homesliders.add',compact('user'));
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


    $imagePath = $request->file('image')->store('homeslide_images', 'public');


    Homeslide::create([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
       
        'target_url' => $request->input('target_url'),
        'image' => $imagePath,
    ]);

    return redirect()->route('homesliders.show')->with('success', 'HomeSlide added successfully');
}

public function edit($id)
{
    $user = Auth::guard('admin')->user();
    $homeslider = Homeslide::find($id);
    return view('homesliders.edit', compact('user','homeslider'));
}

public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
    
            'description' => 'required|string|max:255',
            'target_url' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // adjust mime types and max size as needed
        ]);

        $homeslider = Homeslide::findOrFail($id);

        $homeslider->title = $request->input('title');
        $homeslider->description = $request->input('description');
        
        $homeslider->target_url = $request->input('target_url');


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('homeslider_images', 'public');
            $homeslider->image = $imagePath;
        }

        $homeslider->save();

        return redirect()->route('homesliders.show')->with('success', 'Home Slide updated successfully');
    }
    public function destroy($id)
{

    $homeslider = Homeslide::findOrFail($id);

    // Delete the testimonial
    $homeslider->delete();

    return response()->json(['message' => 'Home Slide deleted successfully']);
}


}
