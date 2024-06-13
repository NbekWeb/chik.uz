<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    /**
     * Show the password reset form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request)
    {
        return view('sessions.password.reset')->with([
            'token' => $request->token,
            'email' => $request->email,
        ]);
    }

    /**
     * Reset the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8', // You can adjust validation rules as needed
        ]);

        $response = Password::reset($request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        ), function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password),
            ])->save();
        });

        if ($response == Password::PASSWORD_RESET) {
            return redirect('login')->with('status', __($response));
        } else {
            return back()->withErrors(['email' => [__($response)]]);
        }
    }
}
