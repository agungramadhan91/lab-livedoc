<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

// Route::apiResource('comments', CommentController::class);

Route::middleware('auth')
    ->prefix('comments')
    ->name('comments.')
    ->group(function(){
        Route::get('/', [CommentController::class, 'index'])->name('index');
        Route::post('/', [CommentController::class, 'store'])->name('store');
        Route::get('/{id}', [CommentController::class, 'show'])->name('show');
        Route::patch('/{id}', [CommentController::class, 'update'])->name('update');
        Route::delete('/{id}', [CommentController::class, 'destroy'])->name('destroy');
    });
