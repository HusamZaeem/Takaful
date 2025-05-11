<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CaseFormController;
use App\Http\Controllers\DonationController;

Route::get('/', function () {
    return view('home');
})->name('home');





// Show the form with case types
Route::get('/case-registration', [CaseFormController::class, 'create'])
    ->name('case.registration.form')
    ->middleware('auth');

// Submit the form
Route::post('/case-registration', [CaseFormController::class, 'store'])
    ->name('case.registration.submit')
    ->middleware('auth');

// Show the form for editing a case
Route::get('/case/{id}/edit', [CaseFormController::class, 'edit'])->name('case.edit');
Route::put('/case/{id}', [CaseFormController::class, 'update'])->name('case.update');

//delete case
// Delete route for pending cases
Route::delete('/case/{id}', [CaseFormController::class, 'destroy'])
     ->name('case.destroy')
     ->middleware('auth');




Route::get('/dashboard', [CaseFormController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
});



Route::get('/donations/create', [DonationController::class, 'create'])->name('donations.create');
Route::post('/donations/store', [DonationController::class, 'store'])->name('donations.store');
Route::get('/donations/success', fn() => view('donations.success'))->name('donations.success');

Route::get('/paypal/checkout/{donation}', [DonationController::class, 'redirectToPaypal'])->name('paypal.checkout');
Route::get('/apple-pay', fn() => redirect('https://apple.com/apple-pay'))->name('apple.pay.redirect');
Route::get('/google-pay', fn() => redirect('https://pay.google.com'))->name('google.pay.redirect');




require __DIR__.'/auth.php';

require __DIR__.'/admin.php';

