<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::simplePaginate(10);
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return response()->json(
                [
                    'message' => 'Successfully created user',
                    'data' => $user
                ],
            )->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(
                [
                    'message' => 'Successfully retrieved user',
                    'data' => $user
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

    public function showbyEmail($email)
    {
        try {
            $user = User::where('email', $email)->firstOrFail();
            return response()->json(
                [
                    'message' => 'Successfully retrieved user',
                    'data' => $user
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

    public function update(Request $request, $id)
    {
        try {
            $blog = User::findOrFail($id);
            $blog->update($request->all());
            return response()->json(
                [
                    'message' => 'Successfully updated blog',
                    'data' => $blog
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

    public function destroy($id)
    {
        try {
            $blog = User::findOrFail($id);
            $blog->delete();
            return response()->json(
                [
                    'message' => 'Successfully deleted blog',
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
