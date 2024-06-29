<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Complaint;
use App\Models\Category;
use App\Models\Post;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Post::where('title', 'LIKE', "%{$query}%")->get(); // Adjust to your model and search field

        $formattedResults = $results->map(function ($result) {
            return [
                'url' => url('/blog/' . $result->slug),
                'avatar' => asset('path/to/avatar.png'),
                'name' => $result->title, 
                'created_at' => $result->created_at->diffForHumans(),
            ];
        });

        return response()->json($formattedResults);
    }
}
