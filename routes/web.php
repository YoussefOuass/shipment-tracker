<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ShipmentTrackingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminShipmentController;
use App\Http\Controllers\AdminCarrierController;

// Public routes
Route::get('/', [ShipmentController::class, 'index'])->name('home');
Route::get('/track', [ShipmentController::class, 'track'])->name('track');

// Authentication routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Protected routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // User dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Advanced tracking features
    Route::prefix('shipments/{shipment}')->group(function () {
        // Update location
        Route::post('/update-location', [ShipmentTrackingController::class, 'updateLocation'])
            ->name('shipments.update-location');
        
        // Confirm delivery
        Route::post('/confirm-delivery', [ShipmentTrackingController::class, 'confirmDelivery'])
            ->name('shipments.confirm-delivery');
        
        // Get QR code
        Route::get('/qr-code', [ShipmentTrackingController::class, 'getQrCode'])
            ->name('shipments.qr-code');
        
        // Update notification preferences
        Route::put('/notification-preferences', [ShipmentTrackingController::class, 'updateNotificationPreferences'])
            ->name('shipments.notification-preferences');
        
        // Get location history
        Route::get('/location-history', [ShipmentTrackingController::class, 'getLocationHistory'])
            ->name('shipments.location-history');
    });

    // Admin routes
    Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Example CRUD routes for managing users
        Route::resource('users', AdminUserController::class);

        // Add more resources for other entities (e.g., shipments, carriers)
        Route::resource('shipments', AdminShipmentController::class);
        Route::resource('carriers', AdminCarrierController::class);
    });
});