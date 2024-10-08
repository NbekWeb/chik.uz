<?php

namespace App\Http\Controllers;

use App\Events\AttachmentEvent;
use App\Http\Resources\PostResource;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Services\AttachmentService;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function __construct(protected AttachmentService $attachmentService)
    {
    }

    public function index(Request $request)
    {
        if ($request->category) {
            return PostResource::collection(Category::where('name', $request->category)->firstOrFail()->posts()->latest()->paginate(1)->withQueryString());
        } else if ($request->search) {
            return  PostResource::collection(Post::where('title', 'like', '%' . $request->search . '%')
                ->orWhere('body', 'like', '%' . $request->search . '%')->latest()->paginate(1)->withQueryString());
        }

        return PostResource::collection(Post::latest()->paginate(1));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'images.*' => 'required | image',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        $title = $request->title;
        $category_id = $request->category_id;

        if (!Post::count()) {
            $postId = 1;
        } else {
            $postId = Post::latest()->first()->id + 1;
        }

        $slug = Str::slug($title, '-') . '-' . $postId;
        $user_id = auth()->user()->id;
        $body = $request->input('body');
        $price = $request->input('price');
        $post = new Post();
        $post->title = $title;
        $post->category_id = $category_id;
        $post->slug = $slug;
        $post->user_id = $user_id;
        $post->price = $price;
        $post->body = $body;
        $post->save();


        event(new AttachmentEvent($request->images, $post->images()));
    }

    public function show(Post $post)
    {
        return new PostResource($post->load(['images']));
    }

    public function update(Request $request, Post $post)
    {
        if (auth()->user()->id !== $post->user->id) {
            return abort(403);
        }
        $request->validate([
            'title' => 'required',
            'images.*' => 'nullable|image|min:3',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        $title = $request->title;
        $category_id = $request->category_id;


        $slug = Str::slug($title, '-') . '-' . $post->id;
        $body = $request->input('body');
        $post->title = $title;
        $post->category_id = $category_id;
        $post->slug = $slug;
        $post->body = $body;

        if ($request->images) {
            $oldImages = $post->images;
            $this->attachmentService->destroy($oldImages);
            $post->images()->delete();

            event(new AttachmentEvent($request->images, $post->images()));
        }

        return $post->save();
    }

    public function destroy(Post $post)
    {
        if (auth()->user()->id !== $post->user->id) {
            return abort(403);
        }

        return $post->delete();
    }
}
