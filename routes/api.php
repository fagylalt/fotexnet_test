<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\ScreeningController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/movies')->group(function (): void {
    Route::get('/list', [MovieController::class, 'index']);
    Route::get('/get/{id}', [MovieController::class, 'find']);
    Route::post('/create', [MovieController::class, 'store']);
    Route::post('/update/{id}', [MovieController::class, 'update']);
    Route::delete('/delete/{id}', [MovieController::class, 'destroy']);
});

Route::prefix('/screenings')->group(function (): void {
    Route::get('/list', [ScreeningController::class, 'index']);
    Route::get('/get/{id}', [ScreeningController::class, 'show']);
    Route::post('/create', [ScreeningController::class, 'store']);
    Route::post('/update/{id}', [ScreeningController::class, 'update']);
    Route::delete('/delete/{id}', [ScreeningController::class, 'destroy']);
});
