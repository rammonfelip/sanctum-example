<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CepController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('home')->name('home');

    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');

    Route::get('consultar-cep/{cep}', [CepController::class, 'consultar'])->name('cep.consultar');
});

Route::middleware(['web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
