<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\AdminPanelController;
use App\Http\Controllers\Admin\AdminCaseController;
use App\Http\Controllers\Admin\AdminDonationController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        
        Route::get('/panel', [AdminPanelController::class, 'index'])->name('panel');

        // User
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('admin.users.show');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        
        

        // Cases
        Route::get('/cases', [AdminCaseController::class, 'index'])->name('cases.index');
        Route::delete('/cases/{id}', [AdminCaseController::class, 'destroy'])->name('cases.destroy');
        Route::patch('/cases/{id}', [AdminCaseController::class, 'update'])->name('cases.update');

        // Donations
        Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
        Route::delete('/donations/{id}', [AdminDonationController::class, 'destroy'])->name('donations.destroy');
        Route::patch('/donations/{id}', [AdminDonationController::class, 'update'])->name('donations.update');

    });
});