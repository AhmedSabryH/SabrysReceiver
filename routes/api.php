<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/sms/forward', [\App\Http\Controllers\SmsForwardController::class, 'store'])->name('store');
Route::get('/sms/fetch', [\App\Http\Controllers\SmsForwardController::class, 'fetch'])->name('fetch');
