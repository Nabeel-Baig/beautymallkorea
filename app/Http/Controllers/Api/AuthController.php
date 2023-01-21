<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreAuthRequest;
use App\Http\Requests\Auth\ValidateAuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
	final public function register(StoreAuthRequest $request): JsonResponse
	{
		$user = User::create(handleFiles('users', $request->validated()));
		$user->update(['password' => Hash::make($request->password)]);
		$token = $user->createToken('myapptoken')->plainTextToken;
		$response = [
			'user' => $user,
			'token' => $token
		];
		return response()->json($response, 201);
	}

	final public function login(ValidateAuthRequest $request): JsonResponse
	{
		// check email
		$user = User::whereEmail($request->email)->first();
		// Check password
		if (!$user || !Hash::check($request->password, $user->password)) {
			return response()->json([
				'message' => 'These credentials do not match our records.'
			], 401);
		}
		$token = $user->createToken('myapptoken')->plainTextToken;
		$response = [
			'user' => $user,
			'token' => $token
		];
		return response()->json($response, 201);
	}

	final public function logout(): JsonResponse
	{
		auth()->user()->tokens()->delete();

		return response()->json([
			'message' => 'Logged out'
		]);
	}
}
