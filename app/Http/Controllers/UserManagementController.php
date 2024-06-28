<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{

    public function index()
    {
        $users = User::whereNot('id', auth()->user()->id)->paginate(15);
        return view('pages.superUser.user-management', [
            'users' => $users
        ]);
    }
    public function update(Request $request, $id)
    {
        $user  = User::findOrFail($id);
        if (auth()->user()->role_id == 1 || auth()->user()->id == $user->id) {
            User::find($id)->update([
                'status' => $request->status,
            ]);

            return response()->json(['message' => '200'], 200);
        }
        return response()->json(['message' => 'Что-то пошло не так. Пожалуйста, попробуйте еще раз позже.'], 400);
    }
}
