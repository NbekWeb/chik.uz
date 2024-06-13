<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\GetUserResourceController;
use App\Models\User;
use Illuminate\Http\Request;

class GetUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        return GetUserResourceController::collection($users);
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return new GetUserResourceController($user);
    }
}
