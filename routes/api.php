<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SiteSettingController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\LeadershipController;
use App\Http\Controllers\Api\SchoolAchievementController;
use App\Http\Controllers\Api\ProgrammeImageController;
use App\Http\Controllers\ProfileApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

// Get authenticated user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Profile Management API Routes
Route::middleware('auth:sanctum')->prefix('profile')->group(function () {
    Route::get('/', [ProfileApiController::class, 'show']);
    Route::put('/', [ProfileApiController::class, 'update']);
    Route::post('/password', [ProfileApiController::class, 'changePassword']);
    Route::post('/avatar', [ProfileApiController::class, 'uploadAvatar']);
    Route::delete('/avatar', [ProfileApiController::class, 'deleteAvatar']);
});

// User Management API Routes
Route::middleware('auth:sanctum')->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::put('/{user}', [UserController::class, 'update']);
    Route::patch('/{user}', [UserController::class, 'update']);
    Route::delete('/{user}', [UserController::class, 'destroy']);
    Route::post('/{user}/verify', [UserController::class, 'verify']);
    Route::post('/{user}/unverify', [UserController::class, 'unverify']);
});

// Blog Management API Routes
Route::prefix('blog')->group(function () {
    // Public endpoints
    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/published', [PostController::class, 'published']);
    Route::get('posts/{post}', [PostController::class, 'show']);
    Route::get('posts/slug/{slug}', [PostController::class, 'showBySlug']);
    Route::get('posts/category/{category}', [PostController::class, 'byCategory']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::get('categories/slug/{slug}', [CategoryController::class, 'showBySlug']);

    // Protected endpoints (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        // Posts management
        Route::post('posts', [PostController::class, 'store']);
        Route::put('posts/{post}', [PostController::class, 'update']);
        Route::delete('posts/{post}', [PostController::class, 'destroy']);
        Route::post('posts/{post}/publish', [PostController::class, 'publish']);
        Route::post('posts/{post}/unpublish', [PostController::class, 'unpublish']);

        // Categories management
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    });
});

// Site Settings API Routes
Route::prefix('site-settings')->group(function () {
    // Basic Information
    Route::get('basic-info', [SiteSettingController::class, 'getBasicInfo']);
    Route::get('contact-info', [SiteSettingController::class, 'getContactInfo']);
    Route::get('social-media', [SiteSettingController::class, 'getSocialMedia']);
    Route::get('footer-info', [SiteSettingController::class, 'getFooterInfo']);
    Route::get('seo-settings', [SiteSettingController::class, 'getSeoSettings']);

    // Homepage Settings
    Route::get('homepage', [SiteSettingController::class, 'getHomepageSettings']);
    Route::get('hero-section', [SiteSettingController::class, 'getHeroSection']);
    Route::get('about-section', [SiteSettingController::class, 'getAboutSection']);
    Route::get('achievements', [SiteSettingController::class, 'getAchievements']);
    Route::get('intro-video', [SiteSettingController::class, 'getIntroVideo']);


    // Organizational Structure Page Settings
    Route::get('organizational-structure-page', [SiteSettingController::class, 'getOrganizationalStructurePageData']);

    // About Page Settings
    Route::get('about-page', [SiteSettingController::class, 'getAboutPageData']);

    // Complete settings
    Route::get('all', [SiteSettingController::class, 'getAllSettings']);
});

// Services API Routes
Route::prefix('services')->group(function () {
    // Public endpoints (for frontend consumption)
    Route::get('/', [ServiceController::class, 'index']);
    Route::get('/{service}', [ServiceController::class, 'show']);

    // Admin endpoints (commented out - manage via Filament admin panel)
    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::post('/', [ServiceController::class, 'store']);
    //     Route::put('/{service}', [ServiceController::class, 'update']);
    //     Route::delete('/{service}', [ServiceController::class, 'destroy']);
    // });
});

// Testimonials API Routes
Route::prefix('testimonials')->group(function () {
    // Public endpoints (for frontend consumption)
    Route::get('/', [TestimonialController::class, 'index']);
    Route::get('/{testimonial}', [TestimonialController::class, 'show']);

    // Admin endpoints (commented out - manage via Filament admin panel)
    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::post('/', [TestimonialController::class, 'store']);
    //     Route::put('/{testimonial}', [TestimonialController::class, 'update']);
    //     Route::delete('/{testimonial}', [TestimonialController::class, 'destroy']);
    // });
});

// Partners API Routes
Route::prefix('partners')->group(function () {
    // Public endpoints (for frontend consumption)
    Route::get('/', [PartnerController::class, 'index']);
    Route::get('/{partner}', [PartnerController::class, 'show']);

    // Admin endpoints (commented out - manage via Filament admin panel)
    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::post('/', [PartnerController::class, 'store']);
    //     Route::put('/{partner}', [PartnerController::class, 'update']);
    //     Route::delete('/{partner}', [PartnerController::class, 'destroy']);
    // });
});

// Leadership API Routes
Route::prefix('leadership')->group(function () {
    // Public endpoints (for frontend consumption)
    Route::get('/', [LeadershipController::class, 'index']);
    Route::get('/{leadership}', [LeadershipController::class, 'show']);

    // Admin endpoints (commented out - manage via Filament admin panel)
    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::post('/', [LeadershipController::class, 'store']);
    //     Route::put('/{leadership}', [LeadershipController::class, 'update']);
    //     Route::delete('/{leadership}', [LeadershipController::class, 'destroy']);
    // });
});

// School Achievement API Routes
Route::prefix('school-achievements')->group(function () {
    // Public endpoints (for frontend consumption)
    Route::get('/', [SchoolAchievementController::class, 'index']);
    Route::get('/{schoolAchievement}', [SchoolAchievementController::class, 'show']);

    // Admin endpoints (commented out - manage via Filament admin panel)
    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::post('/', [SchoolAchievementController::class, 'store']);
    //     Route::put('/{schoolAchievement}', [SchoolAchievementController::class, 'update']);
    //     Route::delete('/{schoolAchievement}', [SchoolAchievementController::class, 'destroy']);
    // });
});

// Programme Images API Routes
Route::prefix('programme-images')->group(function () {
    // Public endpoints (for frontend consumption)
    Route::get('/', [ProgrammeImageController::class, 'index']);
    Route::get('/programme/{programmeName}', [ProgrammeImageController::class, 'byProgrammeName']);
    Route::get('/{programmeImage}', [ProgrammeImageController::class, 'show']);

    // Admin endpoints (commented out - manage via Filament admin panel)
    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::post('/', [ProgrammeImageController::class, 'store']);
    //     Route::put('/{programmeImage}', [ProgrammeImageController::class, 'update']);
    //     Route::delete('/{programmeImage}', [ProgrammeImageController::class, 'destroy']);
    // });
});
