<?php

namespace App\Http\Controllers;
use App\Models\Category; 
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Homeslide;  
use App\Models\PromotionalBanner;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $brandLogos = Brand::all();
        $homeSlides = HomeSlide::all();
        $featuredCategories = Category::where('is_featured', true)->get();
       // dd($featuredCategories);

       $mostOrderedProducts = Product::select(
        'products.id',
        'products.name',
        'products.price',
        'brands.brand_name', 
        DB::raw('COUNT(orders.id) as order_count')
    )
    ->join('order_details', 'products.id', '=', 'order_details.product_id')
    ->join('orders', 'order_details.order_id', '=', 'orders.id')
    ->join('brands', 'products.brand_id', '=', 'brands.id')
    ->groupBy('products.id', 'products.name', 'products.price', 'brands.brand_name')
    ->orderByDesc('order_count')
    ->limit(15)
    ->get();

//dd( $mostOrderedProducts);
   // Get other products
   $otherProducts = Product::whereNotIn('id', $mostOrderedProducts->pluck('id')->toArray())
       ->limit(15 - count($mostOrderedProducts))
       ->get();

   // Merge the two sets of products
   $allProducts = $mostOrderedProducts->merge($otherProducts);
   $promotionalBanners = PromotionalBanner::all();
   
        return view('frontend.home', [
            'brandLogos' => $brandLogos,
            'homeSlides' => $homeSlides,
            'featuredCategories' => $featuredCategories,
            'products' => $allProducts,
            'promotionalBanners' => $promotionalBanners,
        ]);
    }
}

   
