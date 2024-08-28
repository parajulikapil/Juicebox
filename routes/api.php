<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;

// User auth
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

// All routes with auth middleware
Route::middleware('auth:sanctum')->group(function () {

    // users
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('user.show');

    // posts
    Route::resource('/posts', PostController::class)->except(['create', 'edit'])->name('*', 'posts');
});
