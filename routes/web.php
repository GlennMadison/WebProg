<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';




Route::get('/', [ThreadController::class, 'search'])->name('threads.search');
Route::get('threads/create', [ThreadController::class, 'create'])->name('threads.thread.create');
Route::post('threads', [ThreadController::class, 'store'])->name('threads.thread.store');
Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');



Route::get('threads/{thread}', [ThreadController::class, 'show'])->name('threads.thread.show');

Route::post('threads/{thread}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::post('/vote/{type}/{id}', [VoteController::class, 'vote'])->name('vote');

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

