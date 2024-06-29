<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Post::where('title', 'LIKE', "%{$query}%")->with('images')->get();

        $formattedResults = $results->map(function ($result) {
            $firstImageUrl = $result->images->isNotEmpty()
                ? url(Storage::url($result->images->first()->path))
                : asset('assets/img/default.png');

            return [
                'url' => url('/blog/' . $result->slug),
                'image' => $firstImageUrl,
                'name' => $result->title,
                'created_at' => $result->created_at->diffForHumans(),
            ];
        });

        return response()->json($formattedResults);
    }
}
