<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Complaint;
use App\Models\Category;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->get();

        $orders = Order::whereHas('post', function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%");
        })
            ->get();

        $complaints = Complaint::where('comment', 'LIKE', "%{$query}%")
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('post', function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%");
            })
            ->get();

        $categories = Category::where('name', 'LIKE', "%{$query}%")
            ->get();

        return view('pages.search_results', compact('users', 'orders', 'complaints', 'categories'));
    }
}
