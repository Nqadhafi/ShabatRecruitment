<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ApplicantDashboardController;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});


// Login, Register, dan Logout (gunakan middleware guest dan auth)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Dashboard Pelamar dan Admin dengan middleware
Route::middleware('applicant')->get('applicant/dashboard', [ApplicantDashboardController::class, 'index'])->name('applicant.dashboard');
Route::middleware('admin')->get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Rute Admin untuk Manajemen Lowongan Pekerjaan
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::resource('jobs', JobController::class);
    Route::patch('jobs/{job}/toggle', [JobController::class, 'toggle'])->name('admin.jobs.toggle');
    Route::get('grades', function () { return view('admin.grades.index'); })->name('admin.grades.index');
    Route::get('majorities', function () { return view('admin.majorities.index'); })->name('admin.majorities.index');
});
