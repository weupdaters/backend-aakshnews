<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\BreakingNewsController;
use App\Http\Controllers\Admin\InstagramVideoController;
use App\Http\Controllers\Admin\PhotoGalleryController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| All admin route actions follow Laravel standard controller method calls.
|
*/

// Root admin route redirects to dashboard
Route::get('/admin', [AdminAuthController::class, 'redirectAdmin']);

// Admin Login / Logout Routes
Route::get('/admin/login', [AdminAuthController::class, 'loginForm'])->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::match(['get', 'post'], '/admin/logout', [AdminAuthController::class, 'logout']);

// Admin Dashboard Route
Route::get('/admin/dashboard', [DashboardController::class, 'index']);

// Admin Category Management Routes
Route::get('/admin/category', [CategoryController::class, 'index']);
Route::get('/admin/category/create', [CategoryController::class, 'create']);
Route::post('/admin/category', [CategoryController::class, 'store']);
Route::get('/admin/category/{id}/edit', [CategoryController::class, 'edit']);
Route::put('/admin/category/{id}', [CategoryController::class, 'update']);
Route::delete('/admin/category/{id}', [CategoryController::class, 'destroy']);

// Admin Advertisement Management Routes
Route::get('/admin/advertisement', [AdvertisementController::class, 'index']);
Route::get('/admin/advertisement/create', [AdvertisementController::class, 'create']);
Route::post('/admin/advertisement', [AdvertisementController::class, 'store']);
Route::get('/admin/advertisement/{id}/edit', [AdvertisementController::class, 'edit']);
Route::put('/admin/advertisement/{id}', [AdvertisementController::class, 'update']);
Route::delete('/admin/advertisement/{id}', [AdvertisementController::class, 'destroy']);

// Admin News Article & Reader's Corner Management Routes
Route::get('/admin/post', [PostController::class, 'index']);
Route::get('/admin/reader-corner', [PostController::class, 'readerCorner']);
Route::get('/admin/post/create', [PostController::class, 'create']);
Route::get('/admin/post/{id}/edit', [PostController::class, 'edit']);
Route::delete('/admin/post/{id}', [PostController::class, 'destroy']);
Route::post('/admin/post/{id}/duplicate', [PostController::class, 'duplicate']);
Route::post('/admin/post/bulk-action', [PostController::class, 'bulkAction']);

// Admin Breaking News Management Routes
Route::get('/admin/breaking-news', [BreakingNewsController::class, 'index']);
Route::get('/admin/breaking-news/create', [BreakingNewsController::class, 'create']);
Route::post('/admin/breaking-news', [BreakingNewsController::class, 'store']);
Route::get('/admin/breaking-news/{id}/edit', [BreakingNewsController::class, 'edit']);
Route::put('/admin/breaking-news/{id}', [BreakingNewsController::class, 'update']);
Route::delete('/admin/breaking-news/{id}', [BreakingNewsController::class, 'destroy']);

// Admin Instagram Reels Management Routes
Route::get('/admin/instagram', [InstagramVideoController::class, 'index']);
Route::get('/admin/instagram/create', [InstagramVideoController::class, 'create']);
Route::post('/admin/instagram', [InstagramVideoController::class, 'store']);
Route::get('/admin/instagram/{id}/edit', [InstagramVideoController::class, 'edit']);
Route::put('/admin/instagram/{id}', [InstagramVideoController::class, 'update']);
Route::delete('/admin/instagram/{id}', [InstagramVideoController::class, 'destroy']);

// Admin Photo Gallery Management Routes
Route::get('/admin/gallery', [PhotoGalleryController::class, 'index']);
Route::get('/admin/gallery/create', [PhotoGalleryController::class, 'create']);
Route::post('/admin/gallery', [PhotoGalleryController::class, 'store']);
Route::get('/admin/gallery/{id}/edit', [PhotoGalleryController::class, 'edit']);
Route::put('/admin/gallery/{id}', [PhotoGalleryController::class, 'update']);
Route::delete('/admin/gallery/{id}', [PhotoGalleryController::class, 'destroy']);

// Admin Site & Social Media Settings Routes
Route::get('/admin/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings');
Route::post('/admin/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

// Admin Website Settings Route
Route::get('/admin/website-settings', [\App\Http\Controllers\Admin\SettingController::class, 'websiteSettings'])->name('admin.website-settings');
Route::post('/admin/website-settings', [\App\Http\Controllers\Admin\SettingController::class, 'updateWebsiteSettings'])->name('admin.website-settings.update');

// Admin Users & Roles Management Routes
Route::get('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
Route::post('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
Route::put('/admin/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
Route::post('/admin/users/{id}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');

// Admin Newsletter Subscribers Route
Route::get('/admin/subscribers', function () {
    $subscribers = \App\Models\Subscriber::latest()->get();
    return view('admin.subscribers.index', compact('subscribers'));
});

// Admin Reader Messages Route
Route::get('/admin/messages', function () {
    $messages = \App\Models\ContactMessage::latest()->get();
    return view('admin.messages.index', compact('messages'));
});

// Admin Push Notification Broadcast Routes
Route::get('/admin/push', [\App\Http\Controllers\Admin\PushNotificationController::class, 'index']);
Route::post('/admin/push/send', [\App\Http\Controllers\Admin\PushNotificationController::class, 'send']);


