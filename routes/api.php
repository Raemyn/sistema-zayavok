<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SourceController;
use Illuminate\Support\Facades\Route;

// Auth публично
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

// Публичное создание заявки
Route::post('leads', [LeadController::class, 'store']);

// Админ маршруты (Bearer токен через Sanctum)
Route::middleware('auth:sanctum')->group(function() {
    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::get('leads', [LeadController::class, 'index']);
    Route::get('leads/{id}', [LeadController::class, 'show']);
    Route::put('leads/{id}', [LeadController::class, 'update']);
    Route::delete('leads/{id}', [LeadController::class, 'destroy']);

    Route::get('leads/{id}/comments', [CommentController::class, 'index']);
    Route::post('leads/{id}/comments', [CommentController::class, 'store']);
    Route::delete('comments/{id}', [CommentController::class, 'destroy']);

    Route::apiResource('sources', SourceController::class)->except(['show']);
});
