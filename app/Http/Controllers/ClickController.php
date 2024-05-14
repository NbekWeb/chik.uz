<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Click;
use App\Models\PaymentsStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClickController extends Controller
{

    private $secretKey;
    public function __construct()
    {
        $this->secretKey = config('click.secret_key');
    }

    public function prepare(Request $request)
    {
        // logging the request
        Log::info($request);

        // check the request data to errors
        $result = $this->request_check($request);

        $payment = Click::where('click_trans_id', ($request['click_trans_id']))->first();
        if (!$payment) {
            $payment = new Click();
            $payment->click_trans_id = $request['click_trans_id'];
            $payment->user_id = $request['merchant_trans_id'];
            $payment->click_paydoc_id = $request['click_paydoc_id'];
            $payment->amount = $request['amount'];
            $payment->status = PaymentsStatus::INPUT;
            $payment->sign_time = $request['sign_time'];
            $payment->save();
        }

        $merchant_confirm_id = $payment ? $payment->id : 0;
        $merchant_prepare_id = $payment ? $payment->id : 0;

        // Change the payment status to waiting if request data is possible
        if ($result['error'] == 0 && $payment) {
            $payment->update(['status' => PaymentsStatus::WAITING]);
        }

        // Complete the result to response
        $result += [
            'click_trans_id' => $request['click_trans_id'],
            'merchant_trans_id' => $request['merchant_trans_id'],
            'merchant_confirm_id' => $merchant_confirm_id,
            'merchant_prepare_id' => $merchant_prepare_id
        ];
        // return response array
        return $result;
    }

    public function complete(Request $request)
    {
        // logging the request
        Log::info($request);

        $payment = Click::where('click_trans_id', ($request['click_trans_id']))->first();

        $merchant_confirm_id = $payment ? $payment->id : 0;
        $merchant_prepare_id = $payment ? $payment->id : 0;

        $result = $this->request_check($request);
        // Complete the result to response
        $result += [
            'click_trans_id' => $request['click_trans_id'],
            'merchant_trans_id' => $request['merchant_trans_id'],
            'merchant_confirm_id' => $merchant_confirm_id,
            'merchant_prepare_id' => $merchant_prepare_id
        ];

        if ($request['error'] < 0 && !in_array($result['error'], [-4, -9])) {
            // update payment status to error if request data will be error
            $payment->update(['status' => PaymentsStatus::REJECTED]);

            $result = [
                'error' => -9,
                'error_note' => 'Transaction cancelled'
            ];
        } elseif ($result['error'] == 0) {
            // update payment status to confirmed if request data will be success
            $payment->update(['status' => PaymentsStatus::CONFIRMED]);
            $user = User::find($request['merchant_trans_id']);
            if ($user) {
                try {
                    $user->increment('cash', $request['amount']);
                } catch (\Exception $e) {
                    Log::error('Failed to update user cash: ' . $e->getMessage());
                    $result = [
                        'error' => -7,
                        'error_note' => 'Failed to update user cash. Please try again later.'
                    ];
                }
            } else {
                $result = [
                    'error' => -5,
                    'error_note' => 'User not found.'
                ];
            }
        }
        // return response array
        return $result;
    }


    public function request_check($request)
    {
        if ($this->is_not_possible_data($request)) {
            return [
                'error' => -8,
                'error_note' => 'Error in request from click'
            ];
        }

        // prepare sign string as md5 digest
        $sign_string = md5(
            $request['click_trans_id'] .
                $request['service_id'] .
                $this->secretKey .
                $request['merchant_trans_id'] .
                ($request['action'] == 1 ? $request['merchant_prepare_id'] : '') .
                $request['amount'] .
                $request['action'] .
                $request['sign_time']
        );
        // check sign string to possible
        if ($sign_string != $request['sign_string']) {
            return [
                'error' => -1,
                'error_note' => 'SIGN CHECK FAILED!'
            ];
        }

        // check to action not found error
        if (!((int)$request['action'] == 0 || (int)$request['action'] == 1)) {
            return [
                'error' => -3,
                'error_note' => 'Action not found'
            ];
        }

        if (($request['action'] == 0)) {
            // get user data by merchant_trans_id
            $user = User::where('id', $request['merchant_trans_id']);
            if (!$user) {
                return [
                    'error' => -5,
                    'error_note' => 'User does not exist'
                ];
            }
        }


        // get payment data by merchant_prepare_id
        if ($request['action'] == 1) {
            $payment = Click::where('id', $request['merchant_prepare_id']);
            if (!$payment) {
                return [
                    'error' => -6,
                    'error_note' => 'Transaction does not exist	'
                ];
            }
        }

        $payment = Click::where('click_trans_id', $request['click_trans_id'])->first();

        // check to already paid
        if ($payment['status'] == PaymentsStatus::CONFIRMED) {
            return [
                'error' => -4,
                'error_note' => 'Already paid'
            ];
        }

        // check to correct amount
        if ($payment['amount'] !== $request['amount']) {
            return [
                'error' => -2,
                'error_note' => 'Incorrect parameter amount'
            ];
        }

        // check status to transaction cancelled
        if ($payment['status'] == PaymentsStatus::REJECTED) {
            return [
                'error' => -9,
                'error_note' => 'Transaction cancelled'
            ];
        }

        // return response array-like as success
        return [
            'error' => 0,
            'error_note' => 'Success'
        ];
    }
    private function is_not_possible_data($request)
    {
        if (!(
            isset($request['click_trans_id']) &&
            isset($request['service_id']) &&
            isset($request['merchant_trans_id']) &&
            isset($request['amount']) &&
            isset($request['action']) &&
            isset($request['error']) &&
            isset($request['error_note']) &&
            isset($request['sign_time']) &&
            isset($request['sign_string']) &&
            isset($request['click_paydoc_id'])
        ) || $request['action'] == 1 && !isset($request['merchant_prepare_id'])) {
            return true;
        }
        return false;
    }
}
