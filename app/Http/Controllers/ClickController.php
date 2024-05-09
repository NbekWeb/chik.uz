<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Click;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClickController extends Controller
{
    public function prepare(Request $request)
    {
        $clickTransId = $request->input('click_trans_id');
        $serviceId = $request->input('service_id');
        $clickPaydocId = $request->input('click_paydoc_id');
        $merchantTransId = $request->input('merchant_trans_id');
        $amount = $request->input('amount');
        $action = $request->input('action');
        $error = 0;
        $errorNote = 'Success';
        $signTime = $request->input('sign_time');

        $secretKey = 'your_secret_key';

        $generatedSignature = md5($clickTransId . $serviceId . $secretKey . $merchantTransId . $amount . $action . $signTime);

        $receivedSignature = $request->input('sign_string');

        if ($receivedSignature !== $generatedSignature) {
            $error = -1;
            $errorNote = 'SIGN CHECK FAILED!';
        }

        $click = new Click();
        $click->click_trans_id = $clickTransId;
        $click->service_id = $serviceId;
        $click->click_paydoc_id = $clickPaydocId;
        $click->merchant_trans_id = $merchantTransId;
        $click->amount = $amount;
        $click->action = $action;
        $click->sign_time = $signTime;
        $click->save();

        return response()->json([
            'error' => $error,
            'error_note' => $errorNote,
            'click_trans_id' => $clickTransId,
            'service_id' => $serviceId,
            'click_paydoc_id' => $clickPaydocId,
            'merchant_trans_id' => $merchantTransId,
            'amount' => $amount,
            'action' => $action,
            'sign_time' => $signTime,
        ], ($error == 0) ? 200 : 403);
    }

    public function complete(Request $request)
    {
        $clickTransId = $request->input('click_trans_id');
        $serviceId = $request->input('service_id');
        $clickPaydocId = $request->input('click_paydoc_id');
        $merchantTransId = $request->input('merchant_trans_id');
        $merchantPrepareId = $request->input('merchant_prepare_id');
        $amount = $request->input('amount');
        $action = $request->input('action');
        $error = 0;
        $errorNote = 'Success';
        $signTime = $request->input('sign_time');

        $secretKey = 'your_secret_key';

        $generatedSignature = md5($clickTransId . $serviceId . $secretKey . $merchantTransId . $merchantPrepareId . $amount . $action . $signTime);

        $receivedSignature = $request->input('sign_string');

        // Compare signatures
        if ($receivedSignature !== $generatedSignature) {
            $error = -1;
            $errorNote = 'SIGN CHECK FAILED!';
        }

        $click = new Click();
        $click->click_trans_id = $clickTransId;
        $click->service_id = $serviceId;
        $click->click_paydoc_id = $clickPaydocId;
        $click->merchant_trans_id = $merchantTransId;
        $click->merchant_prepare_id = $merchantPrepareId;
        $click->amount = $amount;
        $click->action = $action;
        $click->sign_time = $signTime;
        $click->save();

        return response()->json([
            'error' => $error,
            'error_note' => $errorNote,
            'click_trans_id' => $clickTransId,
            'service_id' => $serviceId,
            'click_paydoc_id' => $clickPaydocId,
            'merchant_trans_id' => $merchantTransId,
            'merchant_prepare_id' => $merchantPrepareId,
            'amount' => $amount,
            'action' => $action,
            'sign_time' => $signTime,
        ], ($error == 0) ? 200 : 403);
    }
}
