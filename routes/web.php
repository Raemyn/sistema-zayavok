<?php

use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

// Публичная форма заявки
Route::get('/lead/create', [LeadController::class, 'create']);

// Страница логина
Route::get('/admin/login', function() {
    return view('admin.login');
})->name('admin.login');

// Админка (JS будет проверять токен)
Route::get('/admin/leads', [LeadController::class, 'admin']);