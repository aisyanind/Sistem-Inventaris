<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    WelcomeController,
    ProfileController,
    DashboardController,
    PerangkatController,
    UplinkController,
    PelangganController,
    StoController,
    PerangkatUplinkController,
    Auth\AuthenticatedSessionController,
    Auth\LoginOtpController,
    Auth\ResetPasswordOtpController
};

Route::middleware('guest')->group(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
    Route::get('/login-redirect', [WelcomeController::class, 'goToLogin'])->name('welcome.login');

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Forgot Password
    Route::get('forgot-password', [ResetPasswordOtpController::class, 'showRequestForm'])->name('password.request');
    Route::post('forgot-password', [ResetPasswordOtpController::class, 'sendOtp'])->name('password.sendOtp');
});

Route::group(['middleware' => ['auth', 'prevent-back-history']], function() {

    Route::middleware(['is_admin'])->group(function () {
        Route::resource('akun', ProfileController::class)->parameters(['akun' => 'user']);
        Route::resource('perangkat', PerangkatController::class)->except(['index', 'show']);
        Route::resource('uplink', UplinkController::class)->except(['index', 'show']);
        Route::resource('sto', StoController::class)->except(['index']);
        Route::resource('perangkat-uplink', PerangkatUplinkController::class)->except(['index']);
        Route::resource('pelanggan', PelangganController::class)->except(['index', 'show']);

        // EXPORT / IMPORT GROUPS
        Route::controller(PerangkatController::class)->prefix('perangkat')->name('perangkat.')->group(function () {
            Route::post('/import', 'import')->name('import');
            Route::get('/template', 'downloadTemplate')->name('template');
            Route::post('/export', 'export')->name('export');
        });

        Route::controller(PelangganController::class)->prefix('pelanggan')->name('pelanggan.')->group(function () {
            Route::post('/export', 'export')->name('export');
            Route::post('/import', 'import')->name('import');
            Route::get('/template', 'downloadTemplate')->name('template');
        });

        Route::controller(UplinkController::class)->prefix('uplink')->name('uplink.')->group(function () {
            Route::post('/export', 'export')->name('export');
            Route::post('/import', 'import')->name('import');
            Route::get('/template', 'downloadTemplate')->name('template');
        });
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard-data/{sto}', [DashboardController::class, 'getDashboardData'])->name('dashboard.data');

    Route::resource('perangkat', PerangkatController::class)->only(['index', 'show']);
    Route::resource('uplink', UplinkController::class)->only(['index', 'show']);
    Route::resource('pelanggan', PelangganController::class)->only(['index']);
    Route::resource('sto', StoController::class)->only(['index']);
    Route::resource('perangkat-uplink', PerangkatUplinkController::class)->only(['index']);
});

Route::group(['middleware' => ['login.pending', 'prevent-back-history']], function() {
    Route::post('otp/login/send', [LoginOtpController::class, 'sendOtp'])->name('otp.login.send');
    Route::get('otp/login', [LoginOtpController::class, 'showOtpForm'])->name('otp.login.form');
    Route::post('otp/login', [LoginOtpController::class, 'verifyOtp'])->name('otp.login.verify');
});

Route::group(['middleware' => ['password.reset.pending', 'prevent-back-history']], function() {
    Route::get('otp/reset', [ResetPasswordOtpController::class, 'showOtpForm'])->name('otp.reset.form');
    Route::post('otp/reset', [ResetPasswordOtpController::class, 'verifyOtp'])->name('otp.reset.verify');
    Route::get('reset-password', [ResetPasswordOtpController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('reset-password', [ResetPasswordOtpController::class, 'resetPassword'])->name('password.update');
});
