<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit')->middleware('guest');

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [LoginController::class, 'register'])->name('register.submit')->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

// ================================================================================================================================= //

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware(['auth', 'role:doctor'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('prescriptions', PrescriptionController::class);
        Route::get('prescriptions/{prescription}/print', [PrescriptionController::class, 'print'])->name('prescriptions.print');
    });

    Route::middleware(['auth', 'role:secretary'])->group(function () {
        Route::resource('patients', PatientController::class);
        Route::resource('appointments', AppointmentController::class);
    });

    Route::middleware(['auth', 'role:patient'])->group(function () {
        Route::get('/book-appointment', [AppointmentController::class, 'createForPatient'])->name('appointments.book');
        Route::post('/book-appointment', [AppointmentController::class, 'storeForPatient'])->name('appointments.book.store');
        Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('my.appointments');
    });
});
