<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonationController;

Route::get('/', function () {
    return view('home');
})->name('home');





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/donations/create', [DonationController::class, 'create'])->name('donations.create');
Route::post('/donations/store', [DonationController::class, 'store'])->name('donations.store');
Route::get('/donations/success', fn() => view('donations.success'))->name('donations.success');

Route::get('/paypal/checkout/{donation}', [DonationController::class, 'redirectToPaypal'])->name('paypal.checkout');
Route::get('/apple-pay', fn() => redirect('https://apple.com/apple-pay'))->name('apple.pay.redirect');
Route::get('/google-pay', fn() => redirect('https://pay.google.com'))->name('google.pay.redirect');




require __DIR__.'/auth.php';

require __DIR__.'/admin.php';

