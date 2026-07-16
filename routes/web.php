<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminNewPasswordController;
use App\Http\Controllers\Admin\AdminPasswordResetLinkController;
use App\Http\Controllers\Admin\QrPassportController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\CleanLogController;
use App\Http\Controllers\Admin\CleaningJobController;
use App\Http\Controllers\Admin\ScheduleTemplateController;
use App\Http\Controllers\Admin\IssueReportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PublicPassportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/oferta', [PageController::class, 'oferta'])->name('oferta');
Route::get('/o-nas', [PageController::class, 'oNas'])->name('o-nas');
Route::get('/kontakt', [PageController::class, 'kontakt'])->name('kontakt');
Route::post('/kontakt', [ContactController::class, 'store'])->name('kontakt.store');

/*
|--------------------------------------------------------------------------
| Publiczny Paszport Czystości (QR) — bez logowania
|--------------------------------------------------------------------------
*/
Route::prefix('passport')->name('passport.')->group(function () {
    Route::get('/{uuid}', [PublicPassportController::class, 'show'])->name('show');
    Route::post('/{uuid}/issue', [PublicPassportController::class, 'storeIssue'])->name('issue');
});

/*
|--------------------------------------------------------------------------
| Panel administracyjny
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // ── Publiczne trasy logowania (gość) ──
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');

        Route::get('/forgot-password', [AdminPasswordResetLinkController::class, 'create'])
            ->name('password.request');
        Route::post('/forgot-password', [AdminPasswordResetLinkController::class, 'store'])
            ->name('password.email');

        Route::get('/reset-password/{token}', [AdminNewPasswordController::class, 'create'])
            ->name('password.reset');
        Route::post('/reset-password', [AdminNewPasswordController::class, 'store'])
            ->name('password.update');
    });

    // ── Wszystkie zalogowane osoby (admin + pracownik + klient) ──
    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Lokalizacje — podgląd (role-aware via policy + controller view)
        Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');

        // Lokalizacje — CRUD (admin, moved before {location} to avoid route collision)
        Route::middleware('admin')->group(function () {
            Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
            Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
        });

        Route::get('/locations/{location}', [LocationController::class, 'show'])->name('locations.show');

        // Zapis sprzątania — pracownik
        Route::get('/clean-logs/create', [CleanLogController::class, 'create'])->name('clean-logs.create');
        Route::post('/clean-logs', [CleanLogController::class, 'store'])->name('clean-logs.store');

        // Zgłoszenia — podgląd (role-aware)
        Route::get('/issue-reports', [IssueReportController::class, 'index'])->name('issue-reports.index');
        Route::post('/issue-reports/{issueReport}/resolve', [IssueReportController::class, 'resolve'])->name('issue-reports.resolve');

        // Zlecenia sprzątania — employee + admin
        Route::get('/jobs', [CleaningJobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/{job}', [CleaningJobController::class, 'show'])->name('jobs.show');
        Route::get('/jobs/{job}/employee', [CleaningJobController::class, 'showForEmployee'])->name('jobs.employee');
        Route::post('/jobs/{job}/start', [CleaningJobController::class, 'start'])->name('jobs.start');
        Route::post('/jobs/{job}/complete', [CleaningJobController::class, 'complete'])->name('jobs.complete');
    });

    // ── Tylko admin ──
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::resource('users', AdminUserController::class);

        // Lokalizacje — CRUD (admin only)
        Route::get('/locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
        Route::put('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
        Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');

        // Paszporty QR — CRUD (admin only)
        Route::resource('passports', QrPassportController::class);

        // Zgłoszenia — admin management
        Route::post('/issue-reports/{issueReport}', [IssueReportController::class, 'update'])->name('issue-reports.update');

        // Szablony harmonogramu — CRUD w lokalizacji (admin only)
        Route::get('/locations/{location}/schedules', [ScheduleTemplateController::class, 'index'])->name('schedules.index');
        Route::get('/locations/{location}/schedules/create', [ScheduleTemplateController::class, 'create'])->name('schedules.create');
        Route::post('/locations/{location}/schedules', [ScheduleTemplateController::class, 'store'])->name('schedules.store');
        Route::get('/locations/{location}/schedules/{template}/edit', [ScheduleTemplateController::class, 'edit'])->name('schedules.edit');
        Route::put('/locations/{location}/schedules/{template}', [ScheduleTemplateController::class, 'update'])->name('schedules.update');
        Route::delete('/locations/{location}/schedules/{template}', [ScheduleTemplateController::class, 'destroy'])->name('schedules.destroy');

        // Zlecenia — admin management (reassign, status)
        Route::post('/jobs/{job}/reassign', [CleaningJobController::class, 'reassign'])->name('jobs.reassign');
        Route::post('/jobs/{job}/status', [CleaningJobController::class, 'updateStatus'])->name('jobs.status');
    });
});
