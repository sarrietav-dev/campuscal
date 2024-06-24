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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get("/campus", function () {
    return Inertia::render("Spaces/Campuses");
})->name("campus")->middleware(["auth", "verified"]);


Route::get("/campus/{id}", function (string $id) {
    return Inertia::render("Spaces/Campus", [
        "id" => $id
    ]);
})->name("campuses")->middleware(["auth", "verified"]);

Route::get("/space/{id}", function (string $id) {
    return Inertia::render("Spaces/Space", [
        "id" => $id
    ]);
})->name("spaces")->middleware(["auth", "verified"]);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
