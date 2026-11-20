<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $bookmarks = auth()->user()->bookmarks()->with('user')->latest()->get();
        return response()->json([
            'bookmarks' => $bookmarks,
        ]);
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
    public function show(Bookmark $bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookmark $bookmark)
    {
        //
    }

    public function toggle($postId){


        $user = auth()->user();
        // return $user->bookmarks;
        $isExisted = $user->bookmarks()->where('post_id',$postId)->exists();

        if($isExisted){
            $user->bookmarks()->detach($postId);
             return response()->json([
            'bookmarked' => false
        ]);
        }

        $user->bookmarks()->attach($postId);
        return response()->json([
            "bookmarked" => true
        ],201);

    }
}
