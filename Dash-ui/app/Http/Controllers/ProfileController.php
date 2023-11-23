<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchCurrentPassword;

class ProfileController extends Controller
{
    public function viewProfile()
    {
        $user = Auth::guard('admin')->user();
        return view('profile.show', compact('user'));
    }

    // public function editProfile()
    // {
    //     $user = Auth::guard('admin')->user();
    //     return view('profile.edit', compact('user'));
    // }

    public function updateProfile(Request $request)
{
    $user = Auth::guard('admin')->user();

    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    ]);

    // Update user's profile
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->save();

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
}

public function updatePassword(Request $request)
    {
        $user = Auth::guard('admin')->user();

        // Validate the request
        $request->validate([
            'currentPassword' => ['required', new MatchCurrentPassword],
            'newPassword' => 'required|string|min:8|different:currentPassword',
            'confirmPassword' => 'required|string|same:newPassword',
        ]);

        // Check if the current password matches the authenticated user's password
        if (!Hash::check($request->input('currentPassword'), $user->password)) {
            return redirect()->route('profile.show')->with('error', 'Current password is incorrect.');
        }

        // Update user's password
        $user->password = Hash::make($request->input('newPassword'));
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Password updated successfully.');
    }

}
