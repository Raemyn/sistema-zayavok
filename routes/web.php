<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;

// Главная страница
Route::get('/', function () {
    return view('welcome');
});

// Публичная форма заявки
Route::get('/lead-form', [LeadController::class, 'create'])->name('lead.create');

// Мини-админка (требует токен)
Route::get('/admin', [LeadController::class, 'admin'])->name('admin.index');
