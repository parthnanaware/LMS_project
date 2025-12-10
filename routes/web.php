<?php

use App\Http\Controllers\CorseController;
use App\Http\Controllers\enrolmentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\trialController;
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

Route::get('/sd', function () {
return view('studentlayout.studentmaster');})->name('student.dashboard');

// Section routes
Route::get('/section', [SectionController::class, 'index'])->name('section.index');
Route::get('/section/subject/{subject_id}', [SectionController::class, 'index'])->name('section.bySubject');
Route::get('/section/create', [SectionController::class, 'create'])->name('section.create');
Route::get('/section/create/{subject_id}', [SectionController::class, 'create'])->name('section.create.withSubject');
Route::post('/section', [SectionController::class, 'store'])->name('section.store');
Route::get('/section/{section}/edit', [SectionController::class, 'edit'])->name('section.edit');
Route::put('/section/{section}', [SectionController::class, 'update'])->name('section.update');
Route::delete('/section/{id}', [SectionController::class, 'destroy'])->name('section.destroy');

// resource routes
Route::resource('corse', CorseController::class);
Route::resource('student', StudentController::class);
Route::resource('subject', SubjectController::class);
Route::resource('session', SessionController::class);
Route::resource('enrolment', enrolmentController::class);
Route::resource('order', OrderController::class);


// toggle status route
Route::patch('student/{id}/toggle-status', [StudentController::class, 'toggleStatus'])->name('student.toggleStatus');
// Auth routes
Auth::routes();
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::patch('/student/status/{id}', [LoginController::class, 'toggleStatus'])->name('appuser.toggleStatus');
// secion routes
Route::get('/session/section/{section_id}', [SessionController::class, 'bySection'])->name('session.bySection');
Route::get('/sessions/section/{section_id}', [SessionController::class, 'index'])->name('session.bySection');
Route::get('/sections/create', [SectionController::class, 'create'])->name('section.create');
Route::post('/sections', [SectionController::class, 'store'])->name('section.store');
Route::get('/sections', [SectionController::class, 'index'])->name('section.index');

//corse routs
Route::get('/courselist', [CorseController::class, 'index'])->name('courselist');
Route::get('/courseadd', [CorseController::class, 'create'])->name('courseaddform');
Route::post('/courseadd', [CorseController::class, 'store'])->name('courseadd');
Route::post('/ccorse', [CorseController::class, 'store'])->name('ccorse');

//erolment fetch  routs
Route::post('/enrolment/fetch-course', [enrolmentController::class, 'fetchCourse'])
    ->name('enrolment.fetchCourse');
Route::get('/enrolment/create', [enrolmentController::class, 'create'])->name('enrolment.create');
Route::post('/enrolment/store', [enrolmentController::class, 'store'])->name('enrolment.store');
Route::get('/get-course-price/{id}', [enrolmentController::class, 'getCoursePrice']);
Route::put('/enrolment/status/{id}', [enrolmentController::class, 'updateStatus'])->name('enrolment.updateStatus');

// Session routes
Route::get('session', [SessionController::class, 'index'])->name('session.index');
Route::get('session/section/{section_id}', [SessionController::class, 'bySection'])->name('session.bySection');

// Create
Route::get('session/create', [SessionController::class, 'create'])->name('session.create');
Route::get('session/create/{section_id}', [SessionController::class, 'createForSection'])->name('session.createForSection');

// crude
Route::post('session/store', [SessionController::class, 'store'])->name('session.store');
Route::get('session/{id}/edit', [SessionController::class, 'edit'])->name('session.edit');
Route::post('session/{id}/update', [SessionController::class, 'update'])->name('session.update');
Route::delete('session/{id}', [SessionController::class, 'destroy'])->name('session.destroy');


// Enrolment status update
Route::put('/enrolment/status/{id}',[enrolmentController::class, 'updateStatus'])->name('enrolment.updateStatus');


// Place Order (Triggered from checkout button)
Route::post('/place-order', [OrderController::class, 'createOrder'])->name('order.place')->middleware('auth');

// Order Success Page
Route::get('/order-success/{id}', [OrderController::class, 'orderSuccess'])->name('order.success')->middleware('auth');

     // Admin Routes for Order Management
Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders');

    Route::get('/orders/{id}', [OrderController::class, 'adminShow'])->name('admin.orders.show');

    Route::get('/orders/enroll/{id}', [OrderController::class, 'enrollFromOrder'])->name('admin.orders.enroll');
});
