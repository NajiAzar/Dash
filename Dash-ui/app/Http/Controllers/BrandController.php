<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            
            return redirect()->route('login'); 
        }
        $brands = Brand::paginate(10);
        $user = Auth::guard('admin')->user();
     
        return view('brands.index', compact('brands','user'));
    }

    public function add()
    { 
        if (!Auth::guard('admin')->check()) {
            
            return redirect()->route('login'); 
        }
        $user = Auth::guard('admin')->user();
        return view('brands.add', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brandData = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brand_images', 'public');
            $brandData['image'] = $imagePath;
        }

        Brand::create($brandData);

        return redirect()->route('brands.index')->with('success', 'Brand added successfully');
    }

    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            
            return redirect()->route('login'); 
        }
        $user = Auth::guard('admin')->user();
        $brand = Brand::findOrFail($id);
        return view('brands.edit', compact('brand','user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'brand_name' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brand = Brand::findOrFail($id);
        $brandData = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brand_images', 'public');
            $brandData['image'] = $imagePath;
        }

        $brand->update($brandData);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully');
    }
}
