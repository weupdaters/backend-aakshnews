<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reporter\ReporterAuthController;
use App\Http\Controllers\Reporter\ReporterDashboardController;

/*
|--------------------------------------------------------------------------
| Reporter Portal Routes (Laravel Backend)
|--------------------------------------------------------------------------
|
| Dedicated routes for Citizen Reporters & Ground Correspondents.
| Includes authentication, report filing, Master Table reports repository,
| AI verification screening, profile, points, settings, and accreditation.
|
*/

// Root reporter portal redirect
Route::get('/reporter', [ReporterAuthController::class, 'index']);

// Authentication Routes
Route::get('/reporter/login', [ReporterAuthController::class, 'loginForm'])->name('reporter.login');
Route::post('/reporter/login', [ReporterAuthController::class, 'login'])->name('reporter.login.submit');
Route::match(['get', 'post'], '/reporter/logout', [ReporterAuthController::class, 'logout'])->name('reporter.logout');

// Protected Reporter Desk Routes
Route::prefix('reporter')->group(function () {
    Route::get('/dashboard', [ReporterDashboardController::class, 'dashboard'])->name('reporter.dashboard');
    
    // News Submissions
    Route::get('/submit-news', [ReporterDashboardController::class, 'submitNews'])->name('reporter.submit-news');
    Route::post('/submit-news', [ReporterDashboardController::class, 'storeNews'])->name('reporter.submit-news.store');
    Route::post('/ai-pre-scan', [ReporterDashboardController::class, 'aiPreScan'])->name('reporter.ai-pre-scan');

    // Master Reports Repository
    Route::get('/my-reports', [ReporterDashboardController::class, 'myReports'])->name('reporter.my-reports');
    Route::get('/reports/{id}', [ReporterDashboardController::class, 'showReport'])->name('reporter.report.show');

    // Profile & Credentials
    Route::get('/profile', [ReporterDashboardController::class, 'profile'])->name('reporter.profile');
    Route::post('/profile', [ReporterDashboardController::class, 'updateProfile'])->name('reporter.profile.update');

    // Notifications
    Route::get('/notifications', [ReporterDashboardController::class, 'notifications'])->name('reporter.notifications');
    Route::post('/notifications/mark-read', [ReporterDashboardController::class, 'markNotificationsRead'])->name('reporter.notifications.read');

    // Settings
    Route::get('/settings', [ReporterDashboardController::class, 'settings'])->name('reporter.settings');
    Route::post('/settings', [ReporterDashboardController::class, 'updateSettings'])->name('reporter.settings.update');

    // Help & Support
    Route::get('/help', [ReporterDashboardController::class, 'help'])->name('reporter.help');
    Route::post('/help/contact-bureau', [ReporterDashboardController::class, 'contactBureau'])->name('reporter.help.contact');

    // Points & Rewards
    Route::get('/points', [ReporterDashboardController::class, 'points'])->name('reporter.points');
    Route::post('/points/redeem', [ReporterDashboardController::class, 'redeemPoints'])->name('reporter.points.redeem');

    // Press ID & Certificates
    Route::get('/certificates', [ReporterDashboardController::class, 'certificates'])->name('reporter.certificates');
});
