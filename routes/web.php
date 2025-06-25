<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
// use App\Http\Controllers\CoursesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

//Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [DashboardController::class, 'viewCourses'])->name('courses');
    Route::get('/create-course', [DashboardController::class, 'viewCreateCourse'])->name('create-course');
    Route::post('/store-course', [DashboardController::class, 'storeCourse'])->name('store-course');
    Route::get('/course/{id}/edit', [CoursesController::class, 'edit'])->name('edit-course');
    Route::patch('/course/{id}/update', [CoursesController::class, 'update'])->name('update-course');
    Route::get('/course/{id}/print', [CoursesController::class, 'print'])->name('print-course');
    Route::delete('/course/{id}/delete', [CoursesController::class, 'delete'])->name('delete-course');


    Route::get('/profile', [DashboardController::class, 'viewProfile'])->name('profile.view');
    Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile-update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile-delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/create-student', [DashboardController::class, 'viewCreateStudent'])->name('create-student');
    Route::post('/store-student', [StudentController::class, 'store'])->name('store-student');
    Route::get('/create-teacher', [DashboardController::class, 'viewCreateTeacher'])->name('create-teacher');
    Route::post('/store-teacher', [TeacherController::class, 'store'])->name('store-teacher');

    Route::get('/students', [StudentController::class, 'index'])->name('students');

    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers');

    Route::get('/other-users', [UserController::class, 'viewOtherUsers'])->name('other-users');

    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('edit-user');
    Route::patch('/user/{id}/update', [UserController::class, 'update'])->name('update-user');
    Route::get('/user/{id}/print', [UserController::class, 'print'])->name('print-user');
    Route::delete('/user/{id}/delete', [UserController::class, 'delete'])->name('delete-user');

    Route::get('teacher-courses', [TeacherController::class, 'courses'])->name('teacher-courses');
    Route::put('/teacher-courses/update/{teacher}', [TeacherController::class, 'updateCoursesTeacher'])->name('update-teacher-courses'); 
    
    Route::get('student-courses', [StudentController::class, 'indexStudentCourses'])->name('student-courses');
    Route::put('/student-courses/update/{student}', [StudentController::class, 'updateStudentCourses'])->name('update-student-courses');

    Route::get('/payments', [DashboardController::class, 'viewPayments'])->name('payments');
    Route::get('/create-payment', [DashboardController::class, 'viewCreatePayment'])->name('create-payment');
    Route::post('/store-payment', [DashboardController::class, 'storePayment'])->name('store-payment');
    Route::delete('/payment/{id}/delete', [DashboardController::class, 'deletePayment'])->name('delete-payment');


    
});

Route::middleware(['auth', 'role:insegnante'])->group(function () {
    Route::get('/insegnante', function () {
        return view('insegnante.dashboard');
    })->name('insegnante.dashboard');
});

Route::middleware(['auth', 'role:studente'])->group(function () {
    Route::get('/studente', function () {
        return view('studente.dashboard');
    })->name('studente.dashboard');
});



require __DIR__.'/auth.php';
