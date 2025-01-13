<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return response()->json(['message' => 'User successfully registered'], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        $token = JWTAuth::getToken();
        Log::info('Token received: ', ['token' => $token]); // Log token untuk debugging
        // return dd($token);
        if (!$token) {
            return response()->json(['error' => 'No token provided'], 400);
        }
    
        try {
            JWTAuth::invalidate($token);
            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not logout', 'details' => $e->getMessage()], 500);
        }
    }
    
    

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function user()
    {
        return response()->json(auth()->user());
    }
}

