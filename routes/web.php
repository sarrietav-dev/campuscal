<?php

/** @noinspection ALL */

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpaceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'can:view-dashboard'])->group(function () {
    Route::resource('campuses', CampusController::class)
        ->only(['index', 'create', 'show', 'store', 'update', 'destroy', 'edit']);

    Route::resource('campuses.spaces', SpaceController::class)
        ->shallow()
        ->only(['create', 'store', 'show', 'edit', 'destroy', 'update']);

    Route::post('/bookings/export', \App\Http\Controllers\ExportBookingController::class)->name('bookings.export');

    Route::resource('bookings', BookingController::class)
        ->only(['index', 'show']);

    Route::patch('bookings/{booking}/approve', \App\Http\Controllers\ApproveBookingController::class)
        ->name('bookings.approve');

    Route::patch('bookings/{booking}/reject', \App\Http\Controllers\RejectBookingController::class)
        ->name('bookings.reject');

    Route::get('/dashboard',
        \App\Http\Controllers\DashboardController::class)->name('dashboard');

    Route::resource('/team', \App\Http\Controllers\TeamMemberController::class)
        ->parameter('team', 'user')
        ->only(['index', 'store', 'destroy', 'update']);
});

Route::get('/bookings/{booking}/public', [BookingController::class, 'show'])
    ->name('bookings.public.show')
    ->middleware('signed');

Route::resource('bookings', BookingController::class)
    ->only(['store']);

Route::get('/', [BookingController::class, 'create'])
    ->name('bookings.create');

Route::prefix('api')->group(function () {
    Route::get('/campuses', [CampusController::class, 'getAll']);
    Route::get('/campuses/{campus}', [CampusController::class, 'getCampus']);
    Route::get('/spaces/{space}', [SpaceController::class, 'getSpace']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/mail', function () {
    if (app()->environment('production')) {
        redirect()->route('dashboard');
    }

    return new \Illuminate\Notifications\Messages\MailMessage();
});

require __DIR__.'/auth.php';
