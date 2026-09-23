<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\InstagramVideoController;
use App\Http\Controllers\BreakingNewsController;
use App\Http\Controllers\PhotoGalleryController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\AiToolController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\SocialVideoController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web & API Routes
|--------------------------------------------------------------------------
|
| All route handlers follow Laravel standard controller method calls.
|
*/

// Redirect root and reader-corner to Admin Dashboard
Route::get('/', [HomeController::class, 'redirectDashboard']);
Route::get('/reader-corner', [HomeController::class, 'redirectDashboard']);

// Authentication Routes
Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);
Route::post('/api/logout', [AuthController::class, 'logout']);
Route::get('/api/user', [AuthController::class, 'user']);

// User Posts Routes
Route::get('/api/posts', [UserPostController::class, 'index']);
Route::get('/api/category-sections', [\App\Http\Controllers\Api\v1\CategoryApiController::class, 'categorySections']);
Route::post('/api/posts', [UserPostController::class, 'store']);
Route::post('/api/posts/{id}/update', [UserPostController::class, 'update']);
Route::delete('/api/posts/{id}', [UserPostController::class, 'destroy']);
Route::post('/api/posts/{id}/approve', [UserPostController::class, 'approve']);
Route::post('/api/posts/{id}/reject', [UserPostController::class, 'reject']);

// Instagram Video Routes
Route::get('/api/instagram-videos', [InstagramVideoController::class, 'index']);
Route::post('/api/instagram-videos', [InstagramVideoController::class, 'store']);
Route::delete('/api/instagram-videos/{id}', [InstagramVideoController::class, 'destroy']);

// Breaking News Routes
Route::get('/api/breaking-news', [BreakingNewsController::class, 'index']);
Route::post('/api/breaking-news', [BreakingNewsController::class, 'store']);
Route::delete('/api/breaking-news/{id}', [BreakingNewsController::class, 'destroy']);

// Photo Gallery Routes
Route::get('/api/photo-gallery', [PhotoGalleryController::class, 'index']);
Route::post('/api/photo-gallery', [PhotoGalleryController::class, 'store']);
Route::delete('/api/photo-gallery/{id}', [PhotoGalleryController::class, 'destroy']);

// Translation & AI Tools Routes
Route::post('/api/translate', [TranslationController::class, 'translate']);
Route::post('/api/generate-description', [AiToolController::class, 'generateDescription']);
Route::post('/api/generate-ai-image', [AiToolController::class, 'generateAiImage']);
Route::post('/api/search-real-images', [AiToolController::class, 'searchRealImages']);
Route::post('/api/save-remote-image', [AiToolController::class, 'saveRemoteImage']);
Route::post('/api/ai-suggest-title', [AiToolController::class, 'suggestTitle']);
Route::post('/api/ai-assistant', [AiToolController::class, 'assistantAction']);

// Miscellaneous & Media Routes
Route::post('/api/subscribe', [NewsletterController::class, 'subscribe']);
Route::post('/api/admin/upload-image', [FileUploadController::class, 'uploadImage']);
Route::get('/api/advertisements', [AdvertisementController::class, 'index']);
Route::get('/test-yt', [SocialVideoController::class, 'testYt']);
Route::get('/api/youtube-videos', [SocialVideoController::class, 'youtubeVideos']);
Route::get('/api/facebook-videos', [SocialVideoController::class, 'facebookVideos']);

// Push Notification Routes
Route::post('/api/push-subscribe', [\App\Http\Controllers\PushNotificationController::class, 'subscribe']);
Route::post('/api/push-unsubscribe', [\App\Http\Controllers\PushNotificationController::class, 'unsubscribe']);
Route::post('/api/send-push', [\App\Http\Controllers\PushNotificationController::class, 'sendPush']);
Route::get('/api/push/status', [\App\Http\Controllers\PushNotificationController::class, 'status']);

// Fallback Route
Route::fallback([HomeController::class, 'fallback']);

