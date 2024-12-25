<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\PodcastController;
use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    // Public routes
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('get-user', [AuthController::class, 'getUser']);
        Route::post('update-user', [AuthController::class, 'updateUser']);
        Route::post('purchase-premium', [AuthController::class, 'purchasePremium']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('podcasts')->group(function () {
        Route::get('get-featured', [PodcastController::class, 'getFeatured']);
        Route::get('get-popular', [PodcastController::class, 'getPopular']);
        Route::get('get-new', [PodcastController::class, 'getNew']);
        Route::prefix('{podcast}')->group(function () {
            Route::get('/', [PodcastController::class, 'getDetailed']);
            Route::get('add-to-saved', [PodcastController::class, 'addToSaved']);
        });
    });

    Route::get('topics', [ResourceController::class, 'getTopics']);
    Route::get('categories', [ResourceController::class, 'getCategories']);
    Route::get('guests', [ResourceController::class, 'getGeusts']);

    Route::prefix('episodes')->group(function () {
        Route::get('search', [EpisodeController::class, 'seachEpisodes']);
        Route::prefix('{episode}')->where(['episode' => '[0-9]+'])->group(function () {
            Route::get('/', [EpisodeController::class, 'getDetailed']);
            Route::get('like', [EpisodeController::class, 'like']);
        });
    });
});
