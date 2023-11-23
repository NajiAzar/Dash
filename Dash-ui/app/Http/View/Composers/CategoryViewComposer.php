<?php

namespace App\Http\View\Composers; // Adjust the namespace as per your directory structure

use Illuminate\View\View;
use App\Models\Category;

class CategoryViewComposer
{
    public function compose(View $view)
    {
        // Fetch categories with subcategories
        $categories = Category::with('subcategories')->where('ParentCategoryID', null)->get();

        // Pass categories to the view
        $view->with('categories', $categories);
    }
}