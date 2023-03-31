<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

// Route::apiResource('comments', CommentController::class);

Route::middleware([
        // 'auth'
    ])
    // ->prefix('comments')
    ->name('comments.')
    ->group(function(){
        Route::get('/comments', [CommentController::class, 'index'])->name('index');
        Route::post('/comments', [CommentController::class, 'store'])->name('store');
        Route::get('/comments/{id}', [CommentController::class, 'show'])->name('show');
        Route::patch('/comments/{id}', [CommentController::class, 'update'])->name('update');
        Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('destroy');
    });
