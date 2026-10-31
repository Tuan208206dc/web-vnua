<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

// Trang chu
Route::get('/', [PostController::class, 'home'])->name('home');

// Danh sach bai viet
Route::get('/post', [PostController::class, 'index'])->name('post.index');

// Dang ky
Route::get('/register', [AuthController::class, 'register'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [AuthController::class, 'storeRegister'])
    ->middleware('guest')
    ->name('register.store');

// Dang nhap
Route::get('/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'storeLogin'])
    ->middleware('guest')
    ->name('login.store');

// Quen mat khau
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
    ->middleware('guest')
    ->name('password.email');

// Dat lai mat khau
Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.update');

// Dang xuat
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Cac chuc nang yeu cau dang nhap
Route::middleware('auth')->group(function () {
    Route::get('/post/create', [PostController::class, 'create'])
        ->name('post.create');

    Route::post('/post', [PostController::class, 'store'])
        ->name('post.store');

    Route::get('/post/{id}/edit', [PostController::class, 'edit'])
        ->name('post.edit');

    Route::put('/post/{id}', [PostController::class, 'update'])
        ->name('post.update');

    Route::delete('/post/{id}', [PostController::class, 'destroy'])
        ->name('post.destroy');
});

// Xem chi tiet bai viet
Route::get('/post/{id}', [PostController::class, 'show'])
    ->whereNumber('id')
    ->name('post.show');
