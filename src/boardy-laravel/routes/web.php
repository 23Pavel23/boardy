<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::resource('posts', PostController::class)->middleware('auth');
Route::post('/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');

require __DIR__.'/auth.php';

Route::get('/auth/github', [App\Http\Controllers\Auth\GitHubController::class, 'redirect'])->name('auth.github');
Route::get('/auth/github/callback', [App\Http\Controllers\Auth\GitHubController::class, 'callback']);
Route::get('/health', fn () => response()->json(['ok' => true]));
