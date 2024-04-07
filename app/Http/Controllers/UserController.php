<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
        ]);

        $user = auth()->user();
        $oldImagePath = $user->image;
        $user->fill($validatedData);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images/avatars');
            $user->image = $imagePath;
            $user->save();
            if ($oldImagePath) {
                Storage::delete($oldImagePath);
            }
        } else {
            $user->save();
        }

        // Return success message
        return back()->with('success', 'Profile updated successfully!');
    }


    public function show($id)
    {
        $user = User::find($id);
        $superUser = auth()->user()->role_id;
        $orders = Order::with('post.images')
            ->where('user_id', $id)
            ->latest()
            ->paginate(10);
        if ($superUser == 1) {
            return view('pages.superUser.profile', ['user' => $user, 'orders' => $orders]);
        } else {
            return view('errors.404');
        }
    }
}
