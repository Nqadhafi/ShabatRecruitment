<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\ExamTitleController;
use App\Http\Controllers\Admin\ExamImportController;
use App\Http\Controllers\Admin\ExamQuestionController;
use App\Http\Controllers\ApplicantDashboardController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\VerifyEmailWithoutLoginController;


/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home.index');
});
Route::get('/job-detail', function () {
    return view('home.job-detail');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
Route::middleware(['applicant', 'verified', 'profile'])->prefix('applicant')->group(function(){
    Route::get('/jobs-panel', function () {return view('applicant.job'); })->name('applicant.jobs-panel');
    Route::get('/dashboard', [ApplicantDashboardController::class, 'index'])->name('applicant.dashboard');
});

Route::middleware(['applicant','verified','profile-verified'])->prefix('applicant')->group(function(){
    Route::get('/profile/complete', function(){ return view('applicant.boarding');} )->name('profile.complete');

});

Route::middleware('admin')->get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::resource('jobs', JobController::class);
    Route::patch('jobs/{job}/toggle', [JobController::class, 'toggle'])->name('admin.jobs.toggle');
    Route::get('grades', function () { return view('admin.grades.index'); })->name('admin.grades.index');
    Route::get('majorities', function () { return view('admin.majorities.index'); })->name('admin.majorities.index');

// Exam Titles
    Route::get('/exam-titles', [ExamTitleController::class, 'index'])->name('exam-titles.index');
    Route::get('/exam-titles/create', [ExamTitleController::class, 'create'])->name('exam-titles.create');
    Route::post('/exam-titles', [ExamTitleController::class, 'store'])->name('exam-titles.store');
    Route::get('/exam-titles/{examTitle}', [ExamTitleController::class, 'show'])->name('exam-titles.show');
    Route::get('/exam-titles/{examTitle}/edit', [ExamTitleController::class, 'edit'])->name('exam-titles.edit');
    Route::put('/exam-titles/{examTitle}', [ExamTitleController::class, 'update'])->name('exam-titles.update');
    Route::delete('/exam-titles/{examTitle}', [ExamTitleController::class, 'destroy'])->name('exam-titles.destroy');

    // Exam Questions (Nested)
    Route::get('/exam-titles/{examTitle}/questions', [ExamQuestionController::class, 'index'])->name('exam-questions.index');
    Route::get('/exam-titles/{examTitle}/questions/create', [ExamQuestionController::class, 'create'])->name('exam-questions.create');
    Route::post('/exam-titles/{examTitle}/questions', [ExamQuestionController::class, 'store'])->name('exam-questions.store');
    Route::get('/exam-titles/{examTitle}/questions/{examQuestion}', [ExamQuestionController::class, 'show'])->name('exam-questions.show');
    Route::get('/exam-titles/{examTitle}/questions/{examQuestion}/edit', [ExamQuestionController::class, 'edit'])->name('exam-questions.edit');
    Route::put('/exam-titles/{examTitle}/questions/{examQuestion}', [ExamQuestionController::class, 'update'])->name('exam-questions.update');
    Route::delete('/exam-titles/{examTitle}/questions/{examQuestion}', [ExamQuestionController::class, 'destroy'])->name('exam-questions.destroy');

    // Import & Export
    Route::get('/exam-titles/{examTitle}/questions/import', [ExamImportController::class, 'form'])->name('exam-questions.import.form');
    Route::post('/exam-titles/{examTitle}/questions/import', [ExamImportController::class, 'import'])->name('exam-questions.import.store');
    Route::get('/exam-titles/{examTitle}/questions/export', [ExamImportController::class, 'export'])->name('exam-questions.export');
});


Route::get('email/verify', function () {
    
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerifyEmailWithoutLoginController::class, 'verify'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
