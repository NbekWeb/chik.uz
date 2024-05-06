<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index()
    {
        return view('pages.billing');
    }
    public function payment(Request $request)
    {
        $payme = config('payme.payme_url');
        $amount = $request->amount;
        $user_id = $request->user_id;
        $payment_type = $request->payment_type;
        $return_url  = '/admin/dashboard';
        $client = new Client();

        if ($payment_type == 'payme') {
            Log::info($request);
            $send = $client->post(
                $payme,
                [
                    'form_params' => [
                        'amount' => $amount,
                        'account[id]' => 1,
                        'merchant' => '6634b66b03e7e088228e9224',
                        'allow_redirects' => true,
                    ]
                ]
            );
            $responseBody = $send->getBody()->getContents();
            // Log the response
            Log::info('Payme Response: ' . $responseBody);
        } else {
            return back();
        }
    }
}
