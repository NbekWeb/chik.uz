<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
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

        $user = auth()->user();
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'occupation' => 'nullable|string|max:255',
            'info' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'role_id' => Rule::requiredIf(function () use ($user) {
                return $user->role_id !== 1;
            }),
            Rule::in([2, 3]),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
        ]);

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
        $posts = Post::with('orders')->where('user_id', $id)->paginate(10);
        $inqueries = Order::with(['post.images'])
            ->whereHas('post', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->latest()
            ->paginate(10);
        if ($superUser == 1) {
            return view('pages.superUser.profile', ['user' => $user, 'orders' => $orders, 'posts' => $posts, 'inqueries' => $inqueries]);
        } else {
            return view('errors.404');
        }
    }
}
