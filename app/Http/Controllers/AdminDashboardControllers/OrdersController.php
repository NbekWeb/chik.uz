<?php

namespace App\Http\Controllers\AdminDashboardControllers;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrdersController extends Controller
{
    public function index()
    {
        $orders= Order::orderBy('id', 'DESC')->paginate(15);
        return view('pages.superUser.orders', ['orders' => $orders]);
    }
}
