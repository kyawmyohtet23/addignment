<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // user register
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('userAuthToken')->accessToken;

        return response()->json([
            'result' => 200,
            'message' => 'success',
            'token' => $token,
        ]);
    }

    // user login
    public function login(Request $request)
    {
        $data = $request->only('email', 'password');
        // return $data;
        // $user = Auth::user();
        if (Auth::attempt($data)) {
            $user = Auth::user();
            $token = $user->createToken('userAuthToken')->accessToken;

            // return $user;

            return response()->json([
                'result' => 200,
                'message' => 'success',
                'token' => $token,
            ]);
        } else {
            return response()->json([
                'result' => 500,
                'message' => 'fail',
            ]);
        }
    }


    // logout
    public function logout()
    {
        Auth::user()->token()->revoke();
        return response()->json([
            'result' => 200,
            'message' => 'success'
        ]);
    }
}
