<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [StudentController::class, 'index'])
    ->middleware([
        Authenticate::class,
        EnsureEmailIsVerified::class,
    ])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/
Route::middleware([
    Authenticate::class,
    EnsureEmailIsVerified::class,
])->group(function () {

    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

    Route::get('/students/trash', [StudentController::class, 'trash'])->name('students.trash');
    Route::post('/students/{id}/restore', [StudentController::class, 'restore'])->name('students.restore');
    Route::delete('/students/{id}/force-delete', [StudentController::class, 'forceDelete'])->name('students.force-delete');

    Route::get('/students/export', [StudentController::class, 'export'])->name('students.export');
});

/*
|--------------------------------------------------------------------------
| Course Routes
|--------------------------------------------------------------------------
*/
Route::middleware([
    Authenticate::class,
    EnsureEmailIsVerified::class,
])->group(function () {

    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
});

/*
|--------------------------------------------------------------------------
| Settings Routes
|--------------------------------------------------------------------------
*/
Route::middleware([
    Authenticate::class,
])->group(function () {

    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
