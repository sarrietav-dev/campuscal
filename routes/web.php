<?php

/** @noinspection ALL */

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpaceController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified', 'can:view-dashboard'])->group(function () {
    Route::resource('campuses', CampusController::class)
        ->only(['index', 'create', 'show', 'store']);

    Route::resource('campuses.spaces', SpaceController::class)
        ->shallow()
        ->only(['create', 'store', 'show']);

    Route::resource('bookings', BookingController::class)
        ->only(['index', 'show']);

    Route::patch('bookings/{booking}/approve', [BookingController::class, 'approveBooking'])
        ->name('bookings.approve');

    Route::patch('bookings/{booking}/reject', [BookingController::class, 'rejectBooking'])
        ->name('bookings.reject');

    Route::get('/dashboard', function (\App\Services\BookingStatisticsService $bookingService, \App\Services\SpaceStatisticsService $spaceService) {
        return Inertia::render('Dashboard', [
            'total_bookings_current_month' => $bookingService->getTotalBookingsForCurrentMonth(),
            'pending_bookings' => $bookingService->getTotalPendingBookings(),
            'approved_bookings' => $bookingService->getTotalApprovedBookings(),
            'rejected_bookings' => $bookingService->getTotalRejectedBookings(),
            'most_requested_spaces' => $spaceService->getMostRequestedSpaces(),
        ]);
    })->name('dashboard');

    Route::get('/team', [\App\Http\Controllers\TeamsController::class, 'index'])
        ->name('teams.index')->middleware('permission:view-team');

    Route::post('/team/invite', [\App\Http\Controllers\TeamsController::class, 'invite'])
        ->name('teams.invite')->middleware('permission:invite-member');

    Route::delete('/team/{user}/remove', [\App\Http\Controllers\TeamsController::class, 'remove'])
        ->name('teams.remove')->middleware('permission:remove-member');
});

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

require __DIR__.'/auth.php';
