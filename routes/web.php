<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,15')
        ->name('login.post');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    Route::delete('/cards/bulk-delete', [\App\Http\Controllers\CardController::class, 'bulkDelete'])->name('cards.bulk-delete');
    Route::post('/cards/{card}/toggle-block', [\App\Http\Controllers\CardController::class, 'toggleBlock'])->name('cards.toggle-block');
    Route::resource('cards', \App\Http\Controllers\CardController::class)->except(['edit', 'update']);
    
    Route::get('/pix', [\App\Http\Controllers\PixController::class, 'create'])->name('pix.create');
    Route::post('/pix/generate-qrcode', [\App\Http\Controllers\PixController::class, 'generateQrCode'])->name('pix.generate-qrcode');
    Route::post('/pix/send', [\App\Http\Controllers\PixController::class, 'sendPix'])->name('pix.send');
    Route::get('/pix/history', [\App\Http\Controllers\PixController::class, 'history'])->name('pix.history');
    
    Route::get('/transactions', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [\App\Http\Controllers\TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/filter', [\App\Http\Controllers\TransactionController::class, 'filter'])->name('transactions.filter');
    Route::delete('/transactions/clear-history', [\App\Http\Controllers\TransactionController::class, 'clearHistory'])->name('transactions.clear-history');
});

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});
