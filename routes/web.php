<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Home page with course platform features
Route::get('/', [HomeController::class, 'index'])->name('home');

// Course routes
Route::resource('courses', CourseController::class);
Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    
    // Learning routes (for enrolled students)
    Route::prefix('learn')->name('learn.')->group(function () {
        Route::get('/{course}', function () {
            return Inertia::render('learn/course');
        })->name('course');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
