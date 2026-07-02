<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Admin_side\DashboardController;
use App\Http\Controllers\Admin_side\CategoryController;
use App\Http\Controllers\Admin_side\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User_side\LandingController;


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login-form');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register-form');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::prefix('auth')->group(function () {
    // Google
    Route::get('/google', [SocialAuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('google.callback');

    // Facebook
    Route::get('/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('facebook.login');
    Route::get('/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback'])->name('facebook.callback');

    // Complete registration for social users
    Route::post('/social/register', [SocialAuthController::class, 'completeSocialRegistration'])
        ->name('social.register.complete');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/landing', [LandingController::class, 'index'])->name('user.landing');
});


Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [ReportController::class, 'index'])->name('admin_reports');
    Route::get('/users', [UserController::class, 'index'])->name('manage_users');

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/all', [CategoryController::class, 'showCategory'])->name('categories.all');
        Route::post('/add', [CategoryController::class, 'store'])->name('categories.store');
        Route::post('/get', [CategoryController::class, 'show'])->name('categories.show');
        Route::post('/update', [CategoryController::class, 'update'])->name('categories.update');
        Route::post('/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
});
