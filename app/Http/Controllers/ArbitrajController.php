<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
        $order = Order::where('id', $id)->where('status', 203)->get();
        $request->validate([
            'status' => 'required|integer'
        ]);
    }
}
