<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ApplicantDashboardController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


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


// Login, Register, dan Logout (gunakan middleware guest dan auth)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Dashboard Pelamar dan Admin dengan middleware
Route::middleware(['applicant','verified'])->get('applicant/dashboard', [ApplicantDashboardController::class, 'index'])->name('applicant.dashboard');
Route::middleware(['applicant', 'verified'])->prefix('applicant')->group(function(){
    Route::get('/jobs-panel', function () {return view('applicant.job'); })->name('applicant.jobs-panel');
});


Route::middleware('admin')->get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Rute Admin untuk Manajemen Lowongan Pekerjaan
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::resource('jobs', JobController::class);
    Route::patch('jobs/{job}/toggle', [JobController::class, 'toggle'])->name('admin.jobs.toggle');
    Route::get('grades', function () { return view('admin.grades.index'); })->name('admin.grades.index');
    Route::get('majorities', function () { return view('admin.majorities.index'); })->name('admin.majorities.index');
});


Route::get('email/verify', function () {
    
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/applicant/dashboard')->with('success', 'Email Anda telah diverifikasi! Selamat datang di dashboard pelamar.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
