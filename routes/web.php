<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware('guest')->controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login');
});

Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::controller(\App\Http\Controllers\SmsForwardController::class)->prefix('/sms')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/forward/{id}', 'forward')->name('showForward');
        Route::delete('/forward/{id}', 'destroy')->name('destroy');
        Route::put('/forward/{id}', 'update')->name('update');
    });
});

