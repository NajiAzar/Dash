<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // Import the Category model
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function show()
    {
        $categories = Category::paginate(10);
        $user = Auth::guard('admin')->user();
        return view('categories.show', compact('user', 'categories'));
    }
    public function add()
    {
        $user = Auth::guard('admin')->user();
        $categories = Category::all(); // Retrieve all categories
        // Add logic to display the create category form
        return view('categories.add', compact('user','categories'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'CategoryName' => 'required|max:255',
            'ParentCategoryID' => 'nullable|exists:categories,id',
           'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Description' => 'required',
        ], [
            'image.required' => 'The image is required.',
            'image.image' => 'The image must be a valid image.',
            'image.mimes' => 'The image must be of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image size must not be greater than 2MB.',
        ]);
    
        // Check if a file was uploaded
        if ($request->hasFile('image')) {
            // Handle image file upload
            $imagePath = $request->file('image')->store('category_images', 'public');
        } else {
            return redirect()->back()->withErrors(['image' => 'Please upload an image.']);
        }
       // dd($request->input('ParentCategoryID'));
        // Create a new category instance
        Category::create([
            'CategoryName' => $request->input('CategoryName'),
            'ParentCategoryID' => $request->input('ParentCategoryID'),
            'image' => $imagePath,
            'Description' => $request->input('Description'),
        ]);
    
        // Redirect to a suitable route after storing the category
        return redirect()->route('categories.show');
    }
    
    
    public function edit($id)
{
    $user = Auth::guard('admin')->user();
    $category = Category::find($id);
    $categories = Category::all();  // Or fetch the categories you need for dropdown

    return view('categories.edit', compact('user','category', 'categories'));
}
public function update(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'CategoryName' => 'required|max:255',
        'ParentCategoryID' => 'nullable|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow image to be optional
        'Description' => 'required',
    ]);

    // Find the category
    $category = Category::findOrFail($id);

    // Update the category with the new data
    $category->update([
        'CategoryName' => $request->input('CategoryName'),
        'ParentCategoryID' => $request->input('ParentCategoryID'),
        'Description' => $request->input('Description'),
    ]);

    // Handle image update if a new image is provided
    if ($request->hasFile('image')) {
        // Validate and store the new image
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('category_images', 'public');
        $category->update(['image' => $imagePath]);
    }

    // Redirect to a suitable route after updating the category
    return redirect()->route('categories.show')->with('success', 'Category updated successfully');
}
public function delete($id)
{
    // Find the category
    $category = Category::findOrFail($id);

    // Delete the category
    $category->delete();

    // Redirect to a suitable route after deleting the category
    return redirect()->route('categories.show')->with('success', 'Category deleted successfully');
}
public function toggleFeatured(Request $request)
{
   // dd($request);
    $categoryId = $request->input('categoryId');
    $isFeatured = $request->input('isFeatured');
//dd($isFeatured);
    // Update the is_featured status in the database
    $category = Category::find($categoryId);
 
    $category->is_featured = $isFeatured;
    //dd( $category->is_featured);
    $category->save();

    return response()->json(['message' => 'is_featured status updated successfully']);
}

}
