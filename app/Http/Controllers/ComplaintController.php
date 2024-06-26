<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaint = Complaint::orderBy('id', 'desc')->paginate(15);
        return view('pages.superUser.complaints', ['complaints' => $complaint]);
    }
    public function store(Request $request)
    {
        $auth = auth()->user();
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string|max:65535',
        ]);
        $complaint = new Complaint();
        $complaint->user_id = $auth->id;
        $complaint->post_id = $request->post_id;
        $complaint->comment = $request->comment;
        $complaint->save();
        return response()->json(['message' => 'Жалоба успешно создана'], 201);
    }
    public function update(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $request->validate([
            'status' => 'required|boolean'
        ]);
        $complaint->status = 1;
        $complaint->save();
        $post = Post::findOrFail($complaint->post_id);
        $post->is_active = $request->status;
        $post->save();
        return response()->json(['message' => 'Complaint status updated successfully', 'complaint' => $complaint], 200);
    }

    public function destroy(Complaint $complaint)
    {
        return $complaint->delete();
    }
}
