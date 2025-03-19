<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::get('/user', action: function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('v1/register', [AuthController::class,'register']);
Route::post('v1/login', [AuthController::class,'login']);
Route::get('v1/profile/{username}', [ProfileController::class, 'publicProfile']);

Route::middleware('auth:sanctum')->group(function() {

    Route::post('v1/logout', [AuthController::class, 'logout']);

    Route::prefix('v1/profiles')->group(function() {
        Route::put('/', [ProfileController::class, 'updateUser']);
        Route::post('/links', [ProfileController::class, 'addLink']);
        //Route::put('/links/{id}/order', [ProfileController::class, 'updateLinkOrder']);
        Route::delete('/links/{id}', [ProfileController::class, 'deleteLink']);
        Route::get('/', [ProfileController::class, 'show']);
        Route::post('/{id}', [ProfileController::class, 'upload']);
        Route::get('/{id}', [ProfileController::class, 'showPicture']);
    });
});
