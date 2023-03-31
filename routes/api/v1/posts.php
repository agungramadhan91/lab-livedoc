<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Route::apiResource('posts', PostController::class);

Route::middleware('auth')
    ->prefix('posts')
    ->name('posts.')
    ->group(function(){
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('/{id}', [PostController::class, 'show'])->name('show');
        Route::patch('/{id}', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}', [PostController::class, 'destroy'])->name('destroy');
    });
