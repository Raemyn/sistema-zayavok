<?php


use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

                                                 
Route::get('/getUser', [UserController::class, 'getUsers']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/auth', [UserController::class, 'auth']);

