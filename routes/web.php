<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchedullerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login.page');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [UserController::class, 'store'])->name('user.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/create', [UserController::class, 'store'])->name('user.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{user}/edit', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{user}/delete', [UserController::class, 'destroy'])->name('user.destroy');
        Route::put('/change/password/{user}', [UserController::class, 'changePassword'])->name('user.change.password');
    });

    Route::prefix('/schedullers')->group(function () {
        Route::get('/', [SchedullerController::class, 'index'])->name('scheduller.index');
        Route::post('/create', [SchedullerController::class, 'store'])->name('scheduller.store');
        Route::get('/{scheduller}/edit', [SchedullerController::class, 'edit'])->name('scheduller.edit');
        Route::put('/{scheduller}/edit', [SchedullerController::class, 'update'])->name('scheduller.update');
        Route::delete('/{scheduller}/delete', [SchedullerController::class, 'destroy'])->name('scheduller.destroy');
    });
});
