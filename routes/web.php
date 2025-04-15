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
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCustomerController;

// Public routes
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/track', [ShipmentController::class, 'track'])->name('track');
Route::get('/home', [DashboardController::class, 'redirectToHome'])->name('home');

// Authentication routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Protected routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // User and Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Shipment management routes
    Route::get('/shipments/{shipment}', [ShipmentController::class, 'show'])->name('shipments.show');
    Route::get('/shipments/{shipment}/edit', [ShipmentController::class, 'edit'])->name('shipments.edit');
    Route::put('/shipments/{shipment}', [ShipmentController::class, 'update'])->name('shipments.update');
    Route::delete('/shipments/{shipment}', [ShipmentController::class, 'destroy'])->name('shipments.destroy');
    
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

        // Admin-specific resource routes
        Route::resource('users', AdminUserController::class);
        Route::resource('shipments', AdminShipmentController::class);
        Route::resource('carriers', AdminCarrierController::class);
        Route::resource('customers', AdminCustomerController::class); // Correctly placed here
    });
});

// Admin routes
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'home'])->name('admin.dashboard');
    Route::get('/home', [AdminController::class, 'index'])->name('admin.home'); // Admin Dashboard Route
});

// User dashboard route
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Home route
Route::get('/home', [DashboardController::class, 'redirectToHome'])->name('home');

Route::get('/admin/home', [AdminController::class, 'home'])->name('admin.home');

Route::resource('shipments', ShipmentController::class);
Route::resource('carriers', CarrierController::class);

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'home'])->name('admin.dashboard'); // Admin Panel Route
    Route::resource('customers', AdminCustomerController::class);
    Route::resource('carriers', AdminCarrierController::class);
    Route::resource('shipments', AdminShipmentController::class);
    Route::resource('users', AdminUserController::class);
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/home', [AdminController::class, 'home'])->name('admin.home'); // Admin Dashboard Route
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard'); // Admin Panel Route
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard'); // Admin Panel Route
    Route::get('/home', [AdminController::class, 'home'])->name('admin.home'); // Admin Home Route
});