<?php

// app/Models/Wishlist.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Wishlist extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'product_id'];

    public function customers()
{
    return $this->belongsToMany(Customer::class, 'wishlists', 'product_id', 'customer_id');
}

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function wishlist()
{
    return $this->belongsToMany(Product::class, 'wishlists', 'customer_id', 'product_id');
}

    
}

