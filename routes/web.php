<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('home')->name('home');

    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
});
