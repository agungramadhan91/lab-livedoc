<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

// Route::apiResource('users', UserController::class);

Route::middleware([
        // 'auth'
    ])
    // ->prefix('yuhuu')
    ->name('users.')
    ->group(function(){
        Route::get('/users', [UserController::class, 'index'])
            ->withoutMiddleware('auth')
            ->name('index');
        Route::get('/users/{user}', [UserController::class, 'show'])
            ->where('user', '[0-9]+')
            ->name('show');
        Route::post('/users', [UserController::class, 'store'])->name('store');
        Route::patch('/users/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
