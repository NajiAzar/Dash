<?php

// app/Address.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'postcode',
        'city',
        'state',
        'phone_number',
        'email_address',
    ];

    // You can define relationships here if needed
}
