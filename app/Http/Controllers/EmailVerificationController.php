<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Redirect;

class EmailVerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return Redirect::to('/login')->with('success', 'Email verified successfully. Please log in again to continue.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return Redirect::to('/login')->with('success', 'Email verified successfully. Please log in again to continue.');
    }
}
