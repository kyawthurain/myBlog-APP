<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Profile::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreProfileRequest $request)
    // {
    //     $path   = null;
    //     if ($request->hasFile('profile_pic')) {
    //         $path = $request->file('profile_pic')
    //             ->store('pfps', 'public');
    //     }
    //     $profile = $request->user()->profile()->create([
    //         'username' => $request->username,
    //     ]);
    //     return response()->json([
    //         'profile' => $profile,
    //         'status' => 200,
    //         'message' => 'profile is successfully created'
    //     ]);
    // }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        return $profile;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {

        if($request->has('username')){
            $profile->username = $request->username;
        }

        if($request->has('gender')){
            $profile->gender = $request->gender;
        }

        if($request->has('age')){
            $profile->age = $request->age;
        }
        
      

        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')
                ->store('pfps', 'public');
            $profile->profile_pic = $path;
        }
        $profile->save();

        // $profile->update($request->all());

        return response()->json([
            'profile' => $profile,
            'status' => 200,
            'message' => 'profile is updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
       $profile->delete();
     return response()->json([
        'message' => 'profile is deleted successfully'
       ],200);
    }
}
