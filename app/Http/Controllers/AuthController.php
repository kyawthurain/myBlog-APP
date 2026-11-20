<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|alpha_num|min:3|max:30',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            'role' => 'user'

        ]);

        if ($user) {

            $user->profile()->create([
                'username' => $user->name
            ]);
        }


        return response()->json([
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !(Hash::check($request->password, $user->password))) {
            return response()->json([
                "message" => "Invalid login credentials."
            ], 401);
        }

        $token = $user->createToken($user->name);
        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ], 200);
    }

    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();
        return response()->json([
            "message" => "You are Logged Out"
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile()->first();
        $interests = $user->interests()->get();
        return response()->json([
            'user' => $user,
            'profile' => $profile,
            'interests' => $interests
        ]);
    }
}
