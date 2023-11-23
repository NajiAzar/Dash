<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $fillable = ['CategoryName', 'ParentCategoryID', 'image', 'Description'];
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'ParentCategoryID');
    } 
    public function subcategories() {
        return $this->hasMany(Category::class, 'ParentCategoryID');
    }
//     public function subcategories()
// {
//     return $this->hasMany(Category::class, 'ParentCategoryID', 'CategoryID');
// }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
