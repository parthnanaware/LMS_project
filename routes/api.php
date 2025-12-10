<?php
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\profileController;
    use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CorseController;
use App\Http\Controllers\enrolmentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\subjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/user', [ApiController::class, 'index']);





Route::post('/student/login', [LoginController::class, 'apiLogin']);
Route::middleware('auth:sanctum')->post('/student/logout', [LoginController::class, 'apiLogout']);


// COURSE ROUTES
Route::get('/courses', [CorseController::class, 'apiGetCourses']);
Route::get('/courses/{id}', [CorseController::class, 'apiGetCourseById']);
Route::post('/courses', [CorseController::class, 'apiCreateCourse']);
Route::post('/courses/{id}', [CorseController::class, 'apiUpdateCourse']);
Route::delete('/courses/{id}', [CorseController::class, 'apiDeleteCourse']);
Route::get('/subjects/courses/{course_id}', [CorseController::class, 'getSubjectsByCourse']);





Route::middleware('auth:sanctum')->get('/enrolments/my', [enrolmentController::class, 'myEnrolments']);


Route::get('/subjects/{subject_id}/sections', [SectionController::class, 'getSectionsBySubject']);

// SESSION ROUTES
Route::get('/sections/{section_id}/sessions', [SessionController::class, 'getBySection']);
Route::get('/sessions/{id}', [SessionController::class, 'getSession']);

// SECTION ROUTES
Route::get('/sections/by-subject/{subject_id}', [SectionController::class, 'getSectionsBySubject']);
Route::get('/subject/{id}', [subjectController::class, 'getSubjectById']);

// CART ROUTES
Route::post('/cart/add', [CartController::class, 'addToCart'])->middleware('auth:sanctum');
Route::get('/cart/{user_id}', [CartController::class, 'getCart']);
Route::delete('/cart/remove/{cart_id}', [CartController::class, 'removeCart']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [profileController::class, 'apiShowProfile']);
    Route::post('/profile', [profileController::class, 'apiUpdateProfile']);
});

// ORDER ROUTES
Route::post('/place-order/{user_id}', [OrderController::class, 'apiPlaceOrder']);
