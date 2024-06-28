<?php /** @noinspection ALL */

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\BookingController;

Route::middleware(["auth", "verified"])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::resource('campuses', CampusController::class)
    ->only(['index', 'create', 'show', 'store'])
    ->middleware('auth');

Route::resource('campuses.spaces', SpaceController::class)
    ->shallow()
    ->only(['create', 'store', 'show'])
    ->middleware('auth');

Route::resource('bookings', BookingController::class)
    ->only(['index', 'show', 'store'])
    ->middleware('auth');

Route::get('/', [BookingController::class, 'create'])
    ->name('bookings.create');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
