<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::get('/public/profile/{username}', [ProfileController::class, 'publicProfile']);

Route::middleware('auth:sanctum')->group(function() {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('/profile')->group(function() {
        Route::put('/update', [ProfileController::class, 'updateUser']);
        Route::post('/links', [ProfileController::class, 'addLink']);
        Route::put('/links/{id}/order', [ProfileController::class, 'updateLinkOrder']);
        Route::delete('/links/{id}', [ProfileController::class, 'deleteLink']);
        Route::get('/', [ProfileController::class, 'show']);
    });
});