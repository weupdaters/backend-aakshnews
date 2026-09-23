<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\HomeController;
use App\Http\Controllers\Api\v1\CategoryApiController;
use App\Http\Controllers\Api\v1\NewsApiController;
use App\Http\Controllers\Api\v1\MediaApiController;
use App\Http\Controllers\Api\v1\AuthorApiController;
use App\Http\Controllers\Api\v1\TagApiController;
use App\Http\Controllers\Api\v1\CommentApiController;
use App\Http\Controllers\Api\v1\EngagementApiController;
use App\Http\Controllers\Api\v1\AuthApiController;
use App\Http\Controllers\Api\v1\UserApiController;
use App\Http\Controllers\Api\v1\AdvertisementApiController;

/*
|--------------------------------------------------------------------------
| AAKSH NEWS 2026 REST API Routes (v1)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // -------------------------------------------------------------
    // Authentication Routes
    // -------------------------------------------------------------
    Route::post('/login', [AuthApiController::class, 'login']);
    Route::post('/register', [AuthApiController::class, 'register']);
    Route::post('/auth/login', [AuthApiController::class, 'login']);
    Route::post('/auth/register', [AuthApiController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthApiController::class, 'logout']);
        Route::get('/me', [AuthApiController::class, 'me']);
        Route::post('/auth/logout', [AuthApiController::class, 'logout']);
        Route::get('/auth/me', [AuthApiController::class, 'me']);

        // User Profile & Activity
        Route::get('/profile', [UserApiController::class, 'profile']);
        Route::put('/profile', [UserApiController::class, 'updateProfile']);
        Route::get('/bookmarks', [UserApiController::class, 'bookmarks']);
        Route::get('/history', [UserApiController::class, 'history']);
        Route::get('/notifications', [UserApiController::class, 'notifications']);
        Route::put('/notification/read', [UserApiController::class, 'markNotificationRead']);
        Route::put('/notifications/read', [UserApiController::class, 'markNotificationRead']);

        // Post Engagements
        Route::post('/news/{id}/bookmark', [NewsApiController::class, 'bookmark']);
        Route::post('/news/{id}/like', [NewsApiController::class, 'like']);
    });

    // -------------------------------------------------------------
    // Homepage & Core Info APIs
    // -------------------------------------------------------------
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/settings', [HomeController::class, 'settings']);
    Route::get('/ads', [HomeController::class, 'ads']);
    Route::get('/social', [HomeController::class, 'social']);
    Route::get('/facebook/posts', [HomeController::class, 'facebookPosts']);
    Route::post('/facebook/posts', [HomeController::class, 'addFacebookPost']);
    Route::post('/facebook/sync', [HomeController::class, 'syncFacebookPosts']);

    // Live Widgets
    Route::get('/live-tv', [HomeController::class, 'liveTv']);
    Route::get('/weather', [HomeController::class, 'weather']);
    Route::get('/astrology', [HomeController::class, 'astrology']);
    Route::get('/gold', [HomeController::class, 'gold']);
    Route::get('/fuel', [HomeController::class, 'fuel']);
    Route::get('/market', [HomeController::class, 'market']);
    Route::get('/cricket', [HomeController::class, 'cricket']);
    Route::get('/epaper', [HomeController::class, 'epaper']);

    // -------------------------------------------------------------
    // Categories & Articles
    // -------------------------------------------------------------
    Route::get('/home/category-sections', [CategoryApiController::class, 'categorySections']);
    Route::get('/category-sections', [CategoryApiController::class, 'categorySections']);
    Route::get('/categories', [CategoryApiController::class, 'index']);
    Route::get('/categories/{slug}', [CategoryApiController::class, 'show']);
    Route::get('/categories/{slug}/news', [CategoryApiController::class, 'news']);

    Route::get('/news', [NewsApiController::class, 'index']);
    Route::get('/news/{slug}', [NewsApiController::class, 'show']);
    Route::post('/news/{id}/view', [NewsApiController::class, 'incrementView']);
    Route::post('/news/{id}/share', [NewsApiController::class, 'incrementShare']);

    Route::get('/breaking-news', [NewsApiController::class, 'breakingNews']);
    Route::get('/trending', [NewsApiController::class, 'trending']);
    Route::get('/featured', [NewsApiController::class, 'featured']);

    // -------------------------------------------------------------
    // Media (Videos, Reels & Advertisements)
    // -------------------------------------------------------------
    Route::get('/videos', [MediaApiController::class, 'videos']);
    Route::get('/videos/{slug}', [MediaApiController::class, 'videoShow']);
    Route::get('/reels', [MediaApiController::class, 'reels']);
    Route::get('/reels/{slug}', [MediaApiController::class, 'reelShow']);
    Route::get('/advertisements', [AdvertisementApiController::class, 'index']);

    // -------------------------------------------------------------
    // Authors & Tags
    // -------------------------------------------------------------
    Route::get('/authors', [AuthorApiController::class, 'index']);
    Route::get('/authors/{slug}', [AuthorApiController::class, 'show']);
    Route::get('/tags', [TagApiController::class, 'index']);
    Route::get('/tags/{slug}', [TagApiController::class, 'show']);

    // -------------------------------------------------------------
    // Comments & Community Engagement
    // -------------------------------------------------------------
    Route::get('/news/{id}/comments', [CommentApiController::class, 'index']);
    Route::post('/news/{id}/comments', [CommentApiController::class, 'store']);

    Route::post('/newsletter', [EngagementApiController::class, 'newsletter']);
    Route::post('/contact', [EngagementApiController::class, 'contact']);

    Route::get('/polls', [EngagementApiController::class, 'polls']);
    Route::post('/polls/{id}/vote', [EngagementApiController::class, 'votePoll']);

    // Search API
    Route::get('/search', [NewsApiController::class, 'search']);

    // Push Notification APIs
    Route::post('/push-subscribe', [\App\Http\Controllers\PushNotificationController::class, 'subscribe']);
    Route::post('/push-unsubscribe', [\App\Http\Controllers\PushNotificationController::class, 'unsubscribe']);
    Route::post('/send-push', [\App\Http\Controllers\PushNotificationController::class, 'sendPush']);
    Route::get('/push/status', [\App\Http\Controllers\PushNotificationController::class, 'status']);
});
