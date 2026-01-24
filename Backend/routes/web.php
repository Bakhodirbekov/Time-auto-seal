<?php

use App\Http\Controllers\Admin\AdminPanelController;
use App\Http\Controllers\Admin\BannerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Admin Panel Routes
Route::middleware(['auth', 'role:admin,moderator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminPanelController::class, 'dashboard'])->name('dashboard');
    
    // Cars
    Route::get('/cars', [AdminPanelController::class, 'cars'])->name('cars');
    Route::get('/cars/create', [AdminPanelController::class, 'carsCreate'])->name('cars.create');
    Route::post('/cars', [AdminPanelController::class, 'carsStore'])->name('cars.store');
    Route::get('/cars/{id}/edit', [AdminPanelController::class, 'carsEdit'])->name('cars.edit');
    Route::put('/cars/{id}', [AdminPanelController::class, 'carsUpdate'])->name('cars.update');
    Route::delete('/cars/{id}', [AdminPanelController::class, 'carsDestroy'])->name('cars.destroy');
    Route::delete('/cars/images/{id}', [AdminPanelController::class, 'deleteCarImage'])->name('cars.images.delete');
    Route::post('/cars/{id}/approve', [AdminPanelController::class, 'carsApprove'])->name('cars.approve');
    Route::post('/cars/{id}/toggle-hot-deal', [AdminPanelController::class, 'toggleHotDeal'])->name('cars.toggle-hot-deal');

    Route::get('/hot-deals', [AdminPanelController::class, 'hotDeals'])->name('hot-deals');
    
    // Categories
    Route::get('/categories', [AdminPanelController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminPanelController::class, 'categoriesStore'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminPanelController::class, 'categoriesEdit'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminPanelController::class, 'categoriesUpdate'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminPanelController::class, 'categoriesDestroy'])->name('categories.destroy');

    // Banners - ADMIN & SUPERADMIN ONLY
    Route::middleware(['role:admin,superadmin'])->group(function() {
        Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
        Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
        Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
        Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
        Route::put('/banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
        Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');
    });

    Route::get('/users', [AdminPanelController::class, 'users'])->name('users');
    Route::post('/users/{id}/block', [AdminPanelController::class, 'usersBlock'])->name('users.block');
    Route::post('/users/{id}/unblock', [AdminPanelController::class, 'usersUnblock'])->name('users.unblock');

    Route::get('/complaints', [AdminPanelController::class, 'complaints'])->name('complaints');
    Route::post('/complaints/{id}/resolve', [AdminPanelController::class, 'complaintsResolve'])->name('complaints.resolve');

    Route::get('/timers', [AdminPanelController::class, 'timers'])->name('timers');
    Route::post('/timers/{id}/expire', [AdminPanelController::class, 'timersExpire'])->name('timers.expire');

    Route::get('/notifications', [AdminPanelController::class, 'notifications'])->name('notifications');
    
    // Admin & Superadmin ONLY routes (Staff Management)
    Route::middleware(['role:admin,superadmin'])->group(function() {
        Route::get('/admins', [AdminPanelController::class, 'admins'])->name('admins.index');
        Route::get('/admins/create', [AdminPanelController::class, 'adminsCreate'])->name('admins.create');
        Route::post('/admins', [AdminPanelController::class, 'adminsStore'])->name('admins.store');
        Route::get('/admins/{id}/edit', [AdminPanelController::class, 'adminsEdit'])->name('admins.edit');
        Route::put('/admins/{id}', [AdminPanelController::class, 'adminsUpdate'])->name('admins.update');
        Route::delete('/admins/{id}', [AdminPanelController::class, 'adminsDestroy'])->name('admins.destroy');
    });

    Route::get('/settings', [AdminPanelController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminPanelController::class, 'settingsUpdate'])->name('settings.update');
    Route::post('/profile', [AdminPanelController::class, 'profileUpdate'])->name('profile.update');
});

// API Routes for Frontend
Route::middleware('api')->prefix('api')->group(function() {
    Route::get('/banners', [\App\Http\Controllers\Api\BannerApiController::class, 'index']);
});

// Basic Auth Routes (Simplified)
Route::get('/login', function() {
    return view('auth.login');
})->name('login');

Route::post('/login', [AdminPanelController::class, 'login'])->name('login.post');

Route::post('/logout', function() {
    auth()->logout();
    return redirect('/login');
})->name('logout');
