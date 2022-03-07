<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return response()->json(
                [
                    'message' => 'Successfully register',
                    'data' => $user
                ],
            )->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->firstOrFail();
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken($request->device);

                return response()->json(
                    [
                        'message' => 'Successfully logged in',
                        'data' => $token->plainTextToken,
                    ],
                )->setStatusCode(200);
            } else {
                return response()->json(
                    [
                        'message' => 'Invalid credentials',
                    ],
                )->setStatusCode(401);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'message' => 'User not found',
                ],
            )->setStatusCode(404);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->firstOrFail();
            $user->tokens()->delete();
            return response()->json(
                [
                    'message' => 'Successfully logged out',
                ],
            )->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'message' => 'User not found',
                ],
            )->setStatusCode(404);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->firstOrFail();
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(
                [
                    'message' => 'Successfully reset password',
                ],
            )->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'message' => 'User not found',
                ],
            )->setStatusCode(404);
        }
    }
}
