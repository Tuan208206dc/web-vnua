<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Trang chu blog
Route::get('/', [PostController::class, 'index']);

// Danh sach bai viet
Route::get('/posts', [PostController::class, 'index']);

// Chi tiet bai viet theo ID
Route::get('/post/{id}', [PostController::class, 'show']);
