<?php

namespace App\Http\Controllers;

use App\Models\ReactPost;
use Illuminate\Http\Request;

class ReactPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ReactPost $reactPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReactPost $reactPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReactPost $reactPost)
    {
        //
    }

        public function toggle($postId)
    {


        $user = auth()->user();
        // return $user->bookmarks;
        $isExisted = $user->reactPosts()->where('post_id', $postId)->exists();

        if ($isExisted) {
            $user->reactPosts()->detach($postId);
            return response()->json([
                'liked' => false
            ]);
        }

        $user->reactPosts()->attach($postId);
        return response()->json([
            "liked" => true
        ], 201);
    }
}
