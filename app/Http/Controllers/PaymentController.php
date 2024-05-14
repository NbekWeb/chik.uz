<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Click;
use App\Models\PaymeTransaction;
use App\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $transactions = Transaction::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();
        $payme_transactions = PaymeTransaction::where('owner_id', $user_id)->orderBy('created_at', 'desc')->get();
        $click_transactions = Click::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();

        return view('pages.billing', ['transactions' => $transactions, 'payme_transactions' => $payme_transactions, 'click_transactions' => $click_transactions]);
    }
}
