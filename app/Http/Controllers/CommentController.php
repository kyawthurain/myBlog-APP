<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user')->latest()->get();
        return response()->json([
            'comments' => $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Post $post)
    {
        

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'comment_text' => $request->comment_text
        ]);

        return response()->json([
            'comment' => $comment->load('user')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update($request->all());
        return response()->json([
            'message' => 'comment edited'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            'message' => 'successfully deleted'
        ]);
    }
}
