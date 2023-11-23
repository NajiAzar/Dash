<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Show a specific product
    public function show()
    {
        $user = Auth::guard('admin')->user();
        $totalProductsCount = Product::count();
        $products = Product::paginate(10);
        //$product = Product::findOrFail($id);
        return view('products.show', compact('products','user','totalProductsCount'));
    }

    // Show the form to add a new product
    public function add()
    {
        $user = Auth::guard('admin')->user();
        $categories = Category::all();
        $brands = Brand::all();
        return view('products.add', compact('categories', 'brands','user'));
    }

    // Store a new product
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each image file
        ], [
            'images.*.image' => 'The file must be an image.',
            'images.*.mimes' => 'The file must be of type: jpeg, png, jpg, gif.',
            'images.*.max' => 'The file size must not be greater than 2MB.',
        ]);
    
        // Check if images were uploaded
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                // Handle image file upload
                $imagePath = $image->store('product_images', 'public');
                $imagePaths[] = $imagePath;
            }
        } else {
            return redirect()->back()->withErrors(['images' => 'Please upload at least one image.']);
        }
    
        // Create a new product instance
        $product = Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'brand_id' => $request->input('brand_id'),
        ]);
    
        // Associate images with the product
        foreach ($imagePaths as $imagePath) {
            ProductImage::create([
                'product_id' => $product->id,
                'url' => $imagePath,
            ]);
        }
    
        // Redirect to a suitable route after storing the product
        return redirect()->route('products.show', $product->id);
    }
    public function view($id)
{
    $user = Auth::guard('admin')->user();
    $product = Product::find($id);
    $categories = Category::all();
    $brands = Brand::all();

    return view('products.view', compact('user', 'product', 'categories', 'brands'));
}

    
    public function edit($id)
    {
        $user = Auth::guard('admin')->user();
        $product = Product::find($id);
        $categories = Category::all();
        $brands = Brand::all();
    
        return view('products.edit', compact('user', 'product', 'categories', 'brands'));
    }
    
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Find the product
        $product = Product::findOrFail($id);
    
        // Update the product with the new data
        $product->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'brand_id' => $request->input('brand_id'),
        ]);
    
        // Handle image update if new images are provided
        if ($request->hasFile('images')) {
            // Validate and store the new images
            $request->validate([
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('product_images', 'public');
                $imagePaths[] = $imagePath;
            }
    
            // Delete previous images if needed
            foreach ($product->images as $prevImage) {
                Storage::disk('public')->delete($prevImage->url);
                $prevImage->delete();
            }
    
            // Associate the new images with the product
            foreach ($imagePaths as $imagePath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => $imagePath,
                ]);
            }
        }
    
        // Redirect to a suitable route after updating the product
        return redirect()->route('products.show', $product->id)->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete associated images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->url);
            $image->delete();
        }

        // Delete the product
        $product->delete();

        return redirect()->route('products.show')->with('success', 'Product deleted successfully');
    }
    
}
