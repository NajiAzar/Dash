<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $dates = ['cancelled_date'];

    public $incrementing = true;
    protected $fillable = [
        'customers_id',
        'total',
        'billing_address_id',
        'shipping_address_id',
        'payment_method',
        'status', 
    ];

    public function user()
    {
        return $this->belongsTo(Customer::class);
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }
    

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id');
    }


public function feedback()
{
    return $this->hasOne(Feedback::class);
}
public function products()
    {
        return $this->belongsToMany(Product::class);
    }
 
}