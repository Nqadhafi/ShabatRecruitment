<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ApplicantDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Login dan Registrasi
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
// Dashboard Pelamar (harus melalui middleware applicant)
Route::get('applicant/dashboard', [ApplicantDashboardController::class, 'index'])
    ->middleware('applicant')->name('applicant.dashboard');

// Dashboard Admin (harus melalui middleware admin)
Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware('admin')->name('admin.dashboard');
