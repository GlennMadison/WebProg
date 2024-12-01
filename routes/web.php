<?php

<<<<<<< HEAD
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('index');
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('forums', [ForumController::class, 'index']);

Route::middleware([\App\Http\Middleware\Authenticate::class])->group(function () {
    Route::post('/forums', [ForumController::class, 'store']);
    Route::post('/forums/{forum}/comments', [CommentController::class, 'store']);
});
=======
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
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


Route::get('/', [ThreadController::class, 'index'])->name('threads.thread.index');


Route::get('threads/create', [ThreadController::class, 'create'])->name('threads.thread.create');
Route::post('threads', [ThreadController::class, 'store'])->name('threads.thread.store');


Route::get('threads/{thread}', [ThreadController::class, 'show'])->name('threads.thread.show');

Route::post('threads/{thread}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::post('/vote/{type}/{id}', [VoteController::class, 'vote'])->name('vote');

Route::get('/test-azure', function () {
    $disk = Storage::disk('azure');

    // Test file upload
    $disk->put('test.txt', 'This is a test file');

    return 'File uploaded successfully to Azure!';
});
>>>>>>> test
