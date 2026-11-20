<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Support\Str;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $posts = Post::when($request->has('q'), function ($query) use ($request) {
            $q = $request->q;
            $query->where("title", "like", "%" . $q . "%");
        })->
            with(['user', 'category'])->withExists([
                    'bookmarkedBy as is_bookmarked' => function ($query) {
                        $query->where('user_id', auth()->id());
                    }
                ])->withCount([
                    'reactedBy as reaction_count' => function ($query) {
                        $query->where('user_id', auth()->id());
                    }
                ])->latest('id')->get();
        return response()->json([
            "posts" => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        $path = null;

        if ($request->hasFile('featured_photo')) {
            $path = $request->file('featured_photo')
                ->store('posts', 'public');
        }


        $post = auth()->user()->posts()->create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => Str::slug($request->title),
            'featured_photo' => $path,
            'reaction_count' => 0,
            'category_id' => $request->category_id
        ]);
        return response()->json([
            'post' => $post
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

        return response()->json([
            'post' => $post->load('user', 'category', 'comments'),
            'reaction_count' => $post->reactedBy()->count(),
            'is_reacted' => $post->reactedBy()->whereKey(auth()->id())->exists(),
            'is_bookmarked' => $post->bookmarkedBy()->whereKey(auth()->id())->exists()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        Gate::authorize('modify', $post);

        $path = $post->featured_photo;

        if ($request->hasFile('featured_photo')) {
            $path = $request->file('featured_photo')
                ->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => Str::slug($request->title),
            'featured_photo' => $path,
            'reaction_count' => 0,
            'category_id' => $request->category_id
        ]);
        return [
            'post' => $post,
            'message' => 'post updated successfully'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);
        $post->delete();
        return [

            'message' => 'post deleted successfully'
        ];
    }

    public function userPosts($userId)
    {
        // $user_id = auth()->user()->id;
        $posts = Post::where("user_id", "=", $userId)->withExists([
            'bookmarkedBy as is_bookmarked' => function ($query) {
                $query->where('user_id', auth()->id());
            }
        ])->with('user','category')->latest()->get();


        return response()->json([
            'posts' => $posts,
            'profile' => Profile::where('user_id','=',$userId)->first()
        ]);
    }

    public function featuredPosts()
    {
        $userId = auth()->id();
        $posts = Post::whereHas('category.users', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        })->withExists([
                    'bookmarkedBy as is_bookmarked' => function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    }
                ])->with('user')->latest()->get();
        return response()->json([
            'featured' => $posts
        ]);
    }

    public function countPosts(){
        $count = Post::all()->count();
        return response()->json([
            "count" => $count
        ]);
    }
    public function latestPosts(){
        $posts = Post::latest('created_at')->take(3)->get();
        return response()->json([
            "posts" => $posts
        ]);
    }

}
