<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\StoreAuthRequest;
use App\Http\Requests\auth\ValidateAuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    final public function register(StoreAuthRequest $request)
    {
        $user = User::create(handleFiles('users',$request->validated()));
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }

    final public function login(ValidateAuthRequest $request)
    {
        // check email
        $user = User::whereEmail($request->email)->first();
        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Bad creds'
            ], 401);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
