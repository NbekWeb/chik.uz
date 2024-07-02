<?php

namespace App\Http\Controllers;

use App\Events\OrderStatusChanged;
use App\Models\Arbitraj;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArbitrajController extends Controller
{

    public function index()
    {
        $arbitraj = Order::where('status', 203)->orderBy('id', 'desc')->paginate(15);
        return view('pages.superUser.arbitraj', ['arbitraj' => $arbitraj]);
    }


    public function update(Request $request, $id)
    {
        $order = Order::where('id', $id)->where('status', 203)->first();

        if (!$order) {
            return response('Order not found or cannot be updated', 404);
        }

        $request->validate([
            'status' => 'required|integer'
        ]);
        if ($request->status == 206) {

            event(new OrderStatusChanged($order));

            return $this->orderCancelled($order);
        } elseif ($request->status == 204) {

            event(new OrderStatusChanged($order));

            return $this->orderCompleted($order);
        } else {
            return response('Invalid status update request', 400);
        }
    }

    private function orderCancelled($order)
    {
        $arbitrajHistory = Arbitraj::where('order_id', $order->id)->orderBy('created_at', 'desc')->first();
        if ($arbitrajHistory && in_array($arbitrajHistory->previous_status, [201, 202, 205])) {
            $order->user->increment('cash', $order->post->price);
        }
        $this->arbitrajHistory($order, 206);
        $order->status = 206;
        $order->save();
        return response()->json(['message' => 'Order cancelled'], 201);
    }

    private function orderCompleted($order)
    {
        $freelancer = $order->post->user;

        $arbitrajHistory = Arbitraj::where('order_id', $order->id)->orderBy('created_at', 'desc')->first();

        if ($arbitrajHistory && in_array($arbitrajHistory->previous_status, [201, 202, 205])) {
            $netAmountToTransfer = $this->NetAmountToTransfer($order);
            $freelancer->increment('cash', $netAmountToTransfer);
        }
        $this->arbitrajHistory($order, 204);
        $order->status = 204;
        $order->save();
        return response()->json(['message' => 'Order completed'], 201);
    }

    private function NetAmountToTransfer($order)
    {
        $platformFee = env('PLATFORM_FEE', 20);
        $postPrice = $order->post->price;
        $transferFee = ($postPrice * $platformFee) / 100;
        $netAmountToTransfer = $postPrice - $transferFee;
        return $netAmountToTransfer;
    }

    private function arbitrajHistory($order, $status)
    {
        $newArbitrajHistory = new Arbitraj;
        $newArbitrajHistory->user_id = auth()->user()->id;
        $newArbitrajHistory->order_id = $order->id;
        $newArbitrajHistory->previous_status = $order->status;
        $newArbitrajHistory->after_status = $status;
        $newArbitrajHistory->save();
    }
}
