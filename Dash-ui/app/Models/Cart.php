<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', // Add 'customer_id' to allow mass assignment
        'product_id',
        
        'quantity',
       
        // other fillable attributes
    ];
    public function product() {
        return $this->belongsTo(Product::class, 'product_id'); // Assuming 'product_id' is the foreign key in the 'carts' table
    }
}
