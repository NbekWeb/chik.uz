<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.profile');
    }
    public function edit()
    {
        return view('pages.user.user-profile');
    }
    public function update(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'occupation' => 'nullable|string|max:255',
            'info' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'role_id' => [
                'required',
                Rule::in([2, 3]), // Accept only values 2 or 3 for role_id
            ],
        ]);

        // Retrieve the authenticated user's ID
        $id = auth()->user()->id;

        // Find the user by ID and update the data
        $user = User::find($id);
        if ($user) {
            $user->update($validatedData);
            // Return success message
            return back()->with('success', 'Profile updated successfully!');
        } else {
            // Return error message if user not found
            return back()->with('error', 'User not found!');
        }
    }
}
