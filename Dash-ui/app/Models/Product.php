<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'description', 'category_id', 'brand_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class,);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
