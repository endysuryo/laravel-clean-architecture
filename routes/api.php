<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\StorageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/unauthenticated', function (Request $request) {
    return response()->json(
        [
            'message' => 'Unauthenticated',
        ],
    )->setStatusCode(401);
})->name('unauthenticated');

//auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// user routes
Route::get('/user', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::post('/user', [UserController::class, 'store'])->middleware('auth:sanctum');
Route::get('/user/{slug}', [UserController::class, 'show'])->middleware('auth:sanctum');
Route::get('/user/email/{slug}', [UserController::class, 'showbyEmail'])->middleware('auth:sanctum');
Route::put('/user/{id}', [UserController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->middleware('auth:sanctum');

// blog routes
Route::get('/blog', [BlogController::class, 'index']);
Route::post('/blog', [BlogController::class, 'store'])->middleware('auth:sanctum');
Route::get('/blog/{slug}', [BlogController::class, 'show']);
Route::put('/blog/{id}', [BlogController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/blog/{id}', [BlogController::class, 'destroy'])->middleware('auth:sanctum');

// storage routes
Route::get('/storage', [StorageController::class, 'index'])->middleware('auth:sanctum');
Route::post('/storage', [StorageController::class, 'store'])->middleware('auth:sanctum');
Route::get('/storage/{id}', [StorageController::class, 'show'])->middleware('auth:sanctum');
Route::delete('/storage/{id}', [StorageController::class, 'destroy'])->middleware('auth:sanctum');

