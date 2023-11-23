<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;;


class Customer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name', // Add 'name' to the fillable attributes
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $email = 'email';
    public function orders()
{
    return $this->hasMany(Order::class, 'customers_id');
}
public function feedbacks()
{
    return $this->hasMany(Feedback::class);
}
 
}