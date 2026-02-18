<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

// Customer Authentication
Route::get('/customer/login', [LoginController::class, 'showLoginForm'])->name('customer.login');
Route::post('/customer/login', [LoginController::class, 'login'])->name('customer.login.post');
Route::post('/customer/logout', [LoginController::class, 'logout'])->name('customer.logout');

// Payment
Route::get('/payment/status', [PaymentController::class, 'status'])->name('payment.status');
Route::post('/midtrans/callback', [PaymentController::class, 'callback'])->name('midtrans.callback');

// Customer Dashboard (Protected)
Route::middleware([\App\Http\Middleware\CustomerAuth::class])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/upgrade', [DashboardController::class, 'upgrade'])->name('dashboard.upgrade');
    Route::post('/upgrade', [DashboardController::class, 'processUpgrade'])->name('dashboard.upgrade.process');
});
