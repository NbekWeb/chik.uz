<?php

namespace App\Http\Controllers;

use App\Events\OrderStatusChanged;
use App\Models\Arbitraj;
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
        // sending request to oreder by client
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

                        event(new OrderStatusChanged($order));

                        return response()->json(['message' => 'Статус заказа успешно обновлен'], 200);
                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(['error' => 'Транзакция не удалась'], 500);
                    }
                } else {
                    return response()->json(['error' => 'Недостаточно средств'], 422);
                }
            } else {
                return response()->json(['error' => 'Unauthorized или неподходящий статус заказа'], 403);
            }
        }
        // order starting acceptance from freelancer
        elseif ($request->status == 202) {
            if ($seller->id == $user->id && $order->status == 201) {
                $order->status = 202;
                $order->save();
                event(new OrderStatusChanged($order));
                return response()->json(['message' => "Заказ принят фрилансером"], 200);
            } else {
                return response()->json(['error' => 'Что-то пошло не так. Пожалуйста, попробуйте еще раз позже.'], 500);
            }
        }
        // order completeion approvemnt from client
        elseif ($request->status == 204) {
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
                    event(new OrderStatusChanged($order));
                    return response()->json(['message' => 'Статус заказа: завершение подтверждено'], 200);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['error' => 'Что-то пошло не так. Пожалуйста, попробуйте еще раз позже.'], 500);
                }
            }
        }
        // request to custemer in order to recieve order(after customer recieve will order complete(204) )
        elseif ($request->status == 205) {
            if ($seller->id == $user->id && $order->status == 202) {
                $order->status = 205;
                $order->save();
                event(new OrderStatusChanged($order));
                return response()->json(['message' => "Заказ отправлен клиенту до рассмотрения"], 200);
            } else {
                return response()->json(['error' => 'Что-то пошло не так. Пожалуйста, попробуйте еще раз позже.'], 500);
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
                    event(new OrderStatusChanged($order));
                    return response()->json(['message' => 'Статус заказа: завершение подтверждено'], 200);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['error' => 'Что-то пошло не так. Пожалуйста, попробуйте еще раз позже.'], 500);
                }
            }
        }
    }

    public function forceMajeure(Request $request, $orderId)
    {
        $arbitraj = new Arbitraj;

        $order = Order::findOrFail($orderId);
        if ($order->status == 204) {
            return response()->json(['message' => 'Вы не могли. Заказ уже выполнен']);
        }
        if ($order->status == 206) {
            return response()->json(['message' => 'Вы не могли. Заказ уже отменен']);
        }
        if ($order->status == 203) {
            return response()->json(['message' => 'Вы не могли. Заказ уже в арбитраже']);
        }

        $arbitraj->user_id = auth()->user()->id;
        $arbitraj->order_id = $orderId;
        $arbitraj->previous_status = $order->status;
        $arbitraj->after_status = 203;
        $arbitraj->save();

        $order->status = 203;
        $order->save();

        return response()->json(['message' => 'Статус заказа изменен на форс-мажор.']);
    }
}
