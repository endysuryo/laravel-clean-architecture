<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Storage;
use Illuminate\Support\Facades\Storage as StorageFacade;

class StorageController extends Controller
{
    public function index()
    {
        try {
            $storages = Storage::simplePaginate(10);
            return response()->json($storages, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('public/files');
            $fileSize = $file->getSize();
            $fileType = $file->getMimeType();
            $fileExtension = $file->getClientOriginalExtension();
            $fileMime = $file->getClientMimeType();
            $fileUrl = StorageFacade::url($filePath);

            $storage = Storage::create([
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'file_type' => $fileType,
                'file_extension' => $fileExtension,
                'file_mime' => $fileMime,
                'file_url' => $fileUrl,
            ]);

            return response()->json(
                [
                    'message' => 'Successfully created storage',
                    'data' => $storage
                ],
            )->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $storage = Storage::findOrFail($id);
            return response()->json(
                [
                    'message' => 'Successfully retrieved storage',
                    'data' => $storage
                ],
            )->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'message' => 'Storage not found',
                ],
            )->setStatusCode(404);
        }
    }

    public function destroy($id)
    {
        try {
            $storage = Storage::findOrFail($id);
            $storage->delete();
            return response()->json(
                [
                    'message' => 'Successfully deleted storage',
                ],
            )->setStatusCode(200);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'message' => 'Storage not found',
                ],
            )->setStatusCode(404);
        }
    }
}
