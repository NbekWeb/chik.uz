<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationNoticeController extends Controller
{
    public function showNotice()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
        return view('auth.verify-email');
    }
}
