<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;
use App\Models\Car;


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get(
        'dashboard',
        [CarController::class, 'index']
        //  function () {
        //     return view('dashboard');
        // }
    )->name('dashboard');

    Route::get('createCar',  function () {
        return view('cars.create-car');
    })->name('createCar');


    Route::get('upgrade-car/{id}', function ($id) {
        return view('cars.upgrade-car', ['id' => $id]);
    });

    // Route::get(
    //     'upgrade-car',
    //     function () {
    //         return view('cars.upgrade-car');
    //     }
    // )->name('upgrade-car');

    Route::post('car', [CarController::class, 'store'])->name('car');
    Route::put('car/{id}', [CarController::class, 'update'])->name('car.update');
    Route::get('car/{id}', [CarController::class, 'show'])->name('car.details');
    Route::get('car/delete/{id}', [CarController::class, 'destroy']);
    Route::get('car/upgrade/{id}/{status}', [CarController::class, 'show'])->name('car.upgrade');



    // Route::get('/car-details/{id}', function () {
    //     return "these input is going for test purpose";
    // })->name('car.details');
});
