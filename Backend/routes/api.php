<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\Admin\AdminCarController;
use App\Http\Controllers\Api\Admin\AdminCategoryController;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\Admin\AdminComplaintController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\AdminSettingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

// Public car routes
Route::get('/cars', [CarController::class, 'index']);
Route::get('/cars/hot-deals', [CarController::class, 'hotDeals']);
Route::get('/cars/{id}', [CarController::class, 'show']);

// Categories (public)
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

// Protected user routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // Cars
    Route::post('/cars', [CarController::class, 'store']);
    Route::put('/cars/{id}', [CarController::class, 'update']);
    Route::delete('/cars/{id}', [CarController::class, 'destroy']);
    Route::get('/my-cars', [CarController::class, 'myCars']);

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{carId}', [FavoriteController::class, 'destroy']);
    Route::get('/favorites/check/{carId}', [FavoriteController::class, 'check']);

    // Complaints
    Route::get('/complaints', [ComplaintController::class, 'index']);
    Route::post('/complaints', [ComplaintController::class, 'store']);
    Route::get('/complaints/{id}', [ComplaintController::class, 'show']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
});

// Admin routes
Route::middleware(['auth:sanctum', 'role:admin,moderator'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    // Car Management
    Route::get('/cars', [AdminCarController::class, 'index']);
    Route::get('/cars/pending', [AdminCarController::class, 'pending']);
    Route::get('/cars/{id}', [AdminCarController::class, 'show']);
    Route::put('/cars/{id}', [AdminCarController::class, 'update']);
    Route::delete('/cars/{id}', [AdminCarController::class, 'destroy']);
    Route::post('/cars/{id}/approve', [AdminCarController::class, 'approve']);
    Route::post('/cars/{id}/reject', [AdminCarController::class, 'reject']);
    Route::post('/cars/{id}/toggle-hot-deal', [AdminCarController::class, 'toggleHotDeal']);
    Route::post('/cars/{id}/start-timer', [AdminCarController::class, 'startTimer']);
    Route::post('/cars/{id}/expire-timer', [AdminCarController::class, 'expireTimer']);

    // Category Management
    Route::get('/categories', [AdminCategoryController::class, 'index']);
    Route::post('/categories', [AdminCategoryController::class, 'store']);
    Route::get('/categories/{id}', [AdminCategoryController::class, 'show']);
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update']);
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy']);
    
    // Subcategory Management
    Route::post('/subcategories', [AdminCategoryController::class, 'storeSubcategory']);
    Route::put('/subcategories/{id}', [AdminCategoryController::class, 'updateSubcategory']);
    Route::delete('/subcategories/{id}', [AdminCategoryController::class, 'destroySubcategory']);

    // User Management (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index']);
        Route::get('/users/{id}', [AdminUserController::class, 'show']);
        Route::post('/users/{id}/block', [AdminUserController::class, 'block']);
        Route::post('/users/{id}/unblock', [AdminUserController::class, 'unblock']);
        Route::put('/users/{id}/role', [AdminUserController::class, 'updateRole']);
    });

    // Complaint Management
    Route::get('/complaints', [AdminComplaintController::class, 'index']);
    Route::get('/complaints/{id}', [AdminComplaintController::class, 'show']);
    Route::post('/complaints/{id}/resolve', [AdminComplaintController::class, 'resolve']);
    Route::post('/complaints/{id}/reject', [AdminComplaintController::class, 'reject']);

    // Settings (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/settings', [AdminSettingController::class, 'index']);
        Route::put('/settings', [AdminSettingController::class, 'update']);
    });
});
