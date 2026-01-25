<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Salon routes
    Route::resource('salon', SalonController::class);
    Route::get('/salons', [SalonController::class, 'index'])->name('salon.index');
    
    // Settings routes
        Route::get('/settings/edit', [SalonController::class, 'settingsEdit'])->name('settings.edit');
        Route::get('/settings/show', [SalonController::class, 'settingsShow'])->name('settings.show');
        Route::patch('/settings/update', [SalonController::class, 'settingsUpdate'])->name('settings.update');
    // Nested resources for salon management
    Route::prefix('salon/{salon}')->group(function () {
        // Service routes
        Route::resource('service', ServiceController::class);
        
        // Staff routes
        Route::resource('staff', StaffController::class);
        // API endpoint to get staff services
        Route::get('staff/{staff}/services', [StaffController::class, 'getServices'])->name('staff.services');
        
        // Client routes
        Route::resource('client', ClientController::class);
        
        // Product routes
        Route::resource('product', ProductController::class);
        
        // Booking routes
        Route::resource('booking', BookingController::class);
        Route::get('booking/{booking}/status', [BookingController::class, 'updateStatusForm'])->name('booking.status.form');
        Route::patch('booking/{booking}/status', [BookingController::class, 'updateStatus'])->name('booking.status.update');
    });
    
    // Admin dashboard
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashbord');
    
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/filter-revenue', [DashboardController::class, 'filterRevenue'])->name('admin.filter-revenue');
});

Route::get('/book/{company}', [BookingController::class, 'publicForm'])->name('book');

// Public booking submission
Route::post('/book/{company}', [BookingController::class, 'publicStore'])->name('booking.public.store');

// API endpoint to check staff availability
Route::get('/api/staff/{staff}/availability', [BookingController::class, 'checkStaffAvailability'])->name('staff.availability');

