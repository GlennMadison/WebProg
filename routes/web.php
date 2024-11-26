<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('index');
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('forums', [ForumController::class, 'index']);
    Route::post('forums', [ForumController::class, 'store']);
    Route::post('forums/{forum}/comments', [CommentController::class, 'store']);
});