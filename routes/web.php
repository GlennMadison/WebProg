<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;


Route::get('/test', function () {
    return view('test');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Home (List Threads)
Route::get('/', [ThreadController::class, 'index'])->name('threads.index');

// Create a new thread
Route::get('threads/create', [ThreadController::class, 'create'])->name('threads.create');
Route::post('threads', [ThreadController::class, 'store'])->name('threads.store');

// Show a single thread
Route::get('threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');

// Store a comment on a thread
Route::post('threads/{thread}/comments', [CommentController::class, 'store'])->name('comments.store');