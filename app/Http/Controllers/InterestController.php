<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $interests = auth()->user()->interests()->with('users')->get();
        return response()->json([
            'interests' => $interests
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Interest $interest)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Interest $interest)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Interest $interest)
    // {
    //     //
    // }

    public function toggle($category_id)
    {


        $user = auth()->user();
        // return $user->bookmarks;
        $isExisted = $user->interests()->where('category_id', $category_id)->exists();

        if ($isExisted) {
            $user->interests()->detach($category_id);
            return response()->json([
                'interested' => false
            ]);
        }

        $user->interests()->attach($category_id);
        return response()->json([
            "interested" => true
        ], 201);
    }
}
