<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateOrderStatusController extends Controller
{


    // Order status codes:
    // const ORDER_STATUS_CHATTING = 200;
    // const ORDER_STATUS_PENDING = 201;
    // const ORDER_STATUS_ACCEPTED = 202;
    // const ORDER_STATUS_ORBITRAJ = 203;
    // const ORDER_STATUS_COMPLETED = 204;
    // const ORDER_STATUS_COMPLETED_REQUEST = 205;
    // const ORDER_STATUS_REJECTED = 206;
    // chat 203 va 204 holatda yopiladi

    public function statusUpdate(Request $request, $orderId)
    {
        $user = auth()->user();
        $order = Order::findOrFail($orderId);
        $orderUserId = $order->user_id;
        $seller = $order->post->user;
        $postPrice = $order->post->price;
        if ($request->status == 201) {
            if ($user->id === $orderUserId and $order->status === 200) {
                if ($user->cash >= $postPrice) {
                    DB::beginTransaction();
                    try {
                        $user->decrement('cash', $postPrice);
                        $userTransaction = new Transaction([
                            'order_id' => $order->id,
                            'user_id' => $user->id,
                            'amount' => -$postPrice, // Deduction from buyer's account
                            'transaction_type' => 'deduction',
                            'description' => 'Deduction for post purchase',
                        ]);
                        $order->status = 201;
                        $order->save();
                        $userTransaction->save();
                        DB::commit();
                        return response()->json(['message' => 'Order status updated successfully'], 200);
                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(['error' => 'Transaction failed'], 500);
                    }
                } else {
                    return response()->json(['error' => 'Insufficient funds'], 422);
                }
            } else {
                return response()->json(['error' => 'Unauthorized or unsuitable order status'], 403);
            }
        } elseif ($request->status == 202) {
            if ($seller->id == $user->id && $order->status == 201) {
                $order->status = 202;
                $order->save();
                return response()->json(['message' => "Order accepted by seller"], 200);
            } else {
                return response()->json(['error' => 'Failed'], 500);
            }
        } elseif ($request->status == 204) {
            if ($user->id == $order->user_id and $order->status == 205) {
                DB::beginTransaction();
                try {
                    $order->status = 204;
                    $order->save();
                    // Calculate transfer fee and net amount to transfer
                    $platformFee = env('PLATFORM_FEE', 20);
                    $transferFee = ($postPrice * $platformFee) / 100;
                    $netAmountToTransfer = $postPrice - $transferFee;

                    $sellerTransaction = new Transaction([
                        'user_id' => $seller->id,
                        'order_id' => $order->id,
                        'amount' => $netAmountToTransfer,
                        'transaction_type' => 'transfer_to_seller',
                        'description' => 'Transfer to seller for post purchase',
                    ]);

                    $sellerTransaction->save();
                    $seller->increment('cash', $netAmountToTransfer);
                    DB::commit();
                    return response()->json(['message' => 'Order status completion approved'], 200);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['error' => 'Failed'], 500);
                }
            }
        } elseif ($request->status == 205) {
            if ($seller->id == $user->id && $order->status == 202) {
                $order->status = 205;
                $order->save();
                return response()->json(['message' => "Order submitted to the customer before the review"], 200);
            } else {
                return response()->json(['error' => 'Failed'], 500);
            }
        }
        // cancellation of order in either buyer or seller
        elseif ($request->status == 206) {
            if ($user->id == $order->user_id || $user->id == $seller->id and $order->status == 201) {
                DB::beginTransaction();
                try {
                    $order->status = 206;
                    $order->save();
                    $cancelledTransaction = new Transaction([
                        'user_id' => $order->user_id,
                        'order_id' => $order->id,
                        'amount' => $postPrice,
                        'transaction_type' => 'transfer_to_back',
                        'description' => 'Transfer to customer for post purchasing cancellation',
                    ]);
                    $cancelledTransaction->save();
                    $order->user->increment('cash', $postPrice);
                    DB::commit();
                    return response()->json(['message' => 'Order status completion approved'], 200);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['error' => 'Failed'], 500);
                }
            }
        }
    }

    public function forceMajor(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Perform any checks to ensure that this action is allowed, e.g., check user permissions

        // Change the order status to 203 (or any other status indicating a major failure)
        $order->status = 203;
        $order->save();

        return response()->json(['message' => 'Order status changed to force major.']);
    }
}
