<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;

// Публичная форма
Route::get('/lead/create', [LeadController::class, 'create']);

// Мини-админка (только для авторизованных)
Route::middleware('auth:sanctum')->get('/admin/leads', [LeadController::class, 'admin']);
