<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MatchCurrentPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */ public function passes($attribute, $value)
    {
        // Get the currently authenticated user
        $user = Auth::guard('admin')->user();

        // Check if the entered password matches the user's existing password
        return Hash::check($value, $user->password);
    }

    public function message()
    {
        return 'The current password is incorrect.';
    }
    public function __construct()
    {
        //
    }

  
     
}
