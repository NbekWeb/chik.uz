<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailVerification;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|max:50',
        ]);
        $attributes['password'] = Hash::make(request('password'));

        $user = User::create($attributes);
        SendEmailVerification::dispatch($user);
        auth()->login($user);

        return redirect('/dashboard');
    }
}
