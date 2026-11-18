<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback/list', [FeedbackController::class, 'index'])->name('feedback.index');

Route::get('/posts/trash', [PostController::class, 'trash'])->name('posts.trash');
Route::patch('/posts/{post}/restore', [PostController::class, 'restore'])->withTrashed()->name('posts.restore');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
Route::resource('posts', PostController::class);
