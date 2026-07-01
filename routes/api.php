<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TempImageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
//route publique
Route::get('blogs', [BlogController::class, 'index']);
Route::get('blogs/{id}', [BlogController::class, 'show']);
Route::get('/blogs/{blogId}/comments', [CommentController::class, 'getCommentsByBlog']);
Route::post('/blogs/{blogId}/comments', [CommentController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('save-temp-image', [TempImageController::class, 'store']);
    Route::post('blogs', [BlogController::class, 'store']);
    Route::put('blogs/{id}', [BlogController::class, 'update']);
    Route::delete('blogs/{id}', [BlogController::class, 'delete']);

    Route::get('/admin/comments', [CommentController::class, 'index']);
    Route::delete('/admin/comments/{id}', [CommentController::class, 'destroy']);

    Route::get('/admin/dashboard', [DashboardController::class, 'getStats']);
});

