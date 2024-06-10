<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailVerification;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
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

        return response(['data' => 'success'], 200);
    }
}
