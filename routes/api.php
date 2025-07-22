<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
  Route::post('/register', 'register');
  Route::post('/login', 'login');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('posts', PostController::class);
    Route::post('/posts/{id}/comments', [PostController::class, 'addComment']);
});