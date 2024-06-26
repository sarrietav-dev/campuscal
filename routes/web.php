<?php /** @noinspection ALL */

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/booking', function () {
    return Inertia::render('Booking/CreateBooking');
})->name('booking');

Route::middleware(["auth", "verified"])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get("/campus", function () {
        return Inertia::render("Spaces/Campuses");
    })->name("campus");

    Route::get("/campus/create", function () {
        return Inertia::render("Spaces/CreateCampus");
    })->name("createCampus");

    Route::get("/space/create", function () {
        return Inertia::render("Spaces/CreateSpace");
    })->name("createSpace");


    Route::get("/campus/{id}", function (string $id) {
        return Inertia::render("Spaces/Campus", [
            "id" => $id
        ]);
    })->name("campuses");

    Route::get("/space/{id}", function (string $id) {
        return Inertia::render("Spaces/Space", [
            "id" => $id
        ]);
    })->name("spaces");

    Route::get("/booking/{id}", function (string $id) {
        return Inertia::render("Booking/Index", [
            "id" => $id
        ]);
    })->name("booking");

    Route::get("/bookings", function () {
        return Inertia::render("Booking/Bookings");
    })->name("bookings");

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
