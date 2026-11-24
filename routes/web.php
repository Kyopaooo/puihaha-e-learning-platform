<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, DashboardController, MemberController, CategoryController,
    LevelController, TransactionController, PaymentController, CourseController,
    LessonController
};

Route::get('/', fn () => auth()->check()
    ? redirect()->route('dashboard')
    : redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/email/verify', [AuthController::class, 'verificationNotice'])
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::middleware('verified')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('members', MemberController::class)->except(['destroy']);
        Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
        Route::post('/members/{member}/toggle-status', [MemberController::class, 'toggleStatus'])->name('members.toggle-status');

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('/levels', [LevelController::class, 'index'])->name('levels.index');
        Route::post('/levels', [LevelController::class, 'store'])->name('levels.store');
        Route::put('/levels/{level}', [LevelController::class, 'update'])->name('levels.update');
        Route::delete('/levels/{level}', [LevelController::class, 'destroy'])->name('levels.destroy');

        Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store', 'show']);
        Route::post('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
        Route::post('/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('transactions.cancel');
        Route::get('/transactions/{transaction}/payments/create', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('/transactions/{transaction}/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');

        Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/manage', [CourseController::class, 'manage'])->name('courses.manage');
        Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
        Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
        Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

        Route::post('/courses/{course}/lessons', [LessonController::class, 'store'])->name('lessons.store');
        Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
        Route::get('/courses/{course}/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
        Route::put('/courses/{course}/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
        Route::delete('/courses/{course}/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
        Route::post('/courses/{course}/lessons/{lesson}/complete', [LessonController::class, 'complete'])->name('lessons.complete');
    });
});
