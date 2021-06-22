<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string|unique:users,email',
            'email' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'password' => bcrypt($fields['password']),
            'email' => $fields['email'],
            'address' => $fields['address'],
            'phone' => $fields['phone'],
        ]);
        $token = $user->createToken('token_s')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([

            'password' => 'required|string|unique:users,email',
            'email' => 'required|string',

        ]);

        $user = User::where('email', $fields['email'])->first();
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'invalid email or password'
            ], 401);
        }

        $token = $user->createToken('token_s')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 201);
    }

    public function logout(Request $request)
    {
        
        auth()->user()->tokens()->delete();
        return [
            'message' => 'user logged out',
        ];
    }
}
