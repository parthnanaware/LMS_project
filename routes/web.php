<?php

use App\Http\Controllers\CorseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('profile', [studentController::class, 'showProfile'])->name('profile');



Route::get('/section', [SectionController::class, 'index'])->name('section.index');
Route::get('/section/subject/{subject_id}', [SectionController::class, 'index'])->name('section.bySubject');
Route::get('/section/create', [SectionController::class, 'create'])->name('section.create');
Route::get('/section/create/{subject_id}', [SectionController::class, 'create'])->name('section.create.withSubject');
Route::post('/section', [SectionController::class, 'store'])->name('section.store');
Route::get('/section/{section}/edit', [SectionController::class, 'edit'])->name('section.edit');
Route::put('/section/{section}', [SectionController::class, 'update'])->name('section.update');
Route::delete('/section/{id}', [SectionController::class, 'destroy'])->name('section.destroy');

Route::resource('corse',CorseController::class);
Route::resource('student', StudentController::class);
Route::resource('subject', SubjectController::class);
Route::resource('session', SessionController::class);

Route::patch('/student/{id}/toggle-status', [LoginController::class, 'toggleStatus'])
    ->name('student.toggleStatus');

     Auth::routes();

    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/', [LoginController::class, 'login']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::patch('/student/status/{id}', [LoginController::class, 'toggleStatus'])->name('appuser.toggleStatus');
// View sessions for specific section
Route::get('/session/section/{section_id}', [SessionController::class, 'bySection'])->name('session.bySection');

// Add session for specific section
Route::get('/session/create/section/{section_id}', [SessionController::class, 'createForSection'])->name('session.create.forSection');
Route::get('/sessions/section/{section_id}', [SessionController::class, 'bySection'])->name('session.bySection');
Route::get('/session/create/for-section/{section_id}', [SessionController::class, 'createForSection'])->name('session.create.forSection');


Route::get('/sections/create', [SectionController::class, 'create'])->name('section.create');
Route::post('/sections', [SectionController::class, 'store'])->name('section.store');
Route::get('/sections', [SectionController::class, 'index'])->name('section.index');
