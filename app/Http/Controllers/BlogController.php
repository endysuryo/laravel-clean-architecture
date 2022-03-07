<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        try {
            $blogs = Blog::select([
                'id',
                'title',
                'slug',
                'created_at',
                'updated_at',
            ])->simplePaginate(10);
            return response()->json($blogs, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $blog = Blog::create($request->all());
            return response()->json(
                [
                    'message' => 'Successfully created blog',
                    'data' => $blog
                ],
            )->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    
    public function show($slug)
    {
        try {
            $blog = Blog::where('slug', $slug)->firstOrFail();
            return response()->json(
                [
                    'message' => 'Successfully retrieved blog',
                    'data' => $blog
                ],
            )->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'message' => 'Blog not found',
                ],
            )->setStatusCode(404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $blog = Blog::findOrFail($id);
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
                    'message' => 'Blog not found',
                ],
            )->setStatusCode(404);
        }
    }

    public function destroy($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $blog->delete();
            return response()->json(
                [
                    'message' => 'Successfully deleted blog',
                ],
            )->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'message' => 'Blog not found',
                ],
            )->setStatusCode(404);
        }
    }

}
