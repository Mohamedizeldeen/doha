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
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ContactController;

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
    
    // Super Admin routes (only for super_admin role)
    Route::middleware('role:super_admin')->prefix('superadmin')->name('superAdmin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/salons', [SuperAdminController::class, 'salons'])->name('salons.index');
        Route::get('/salons/create', [SuperAdminController::class, 'createSalon'])->name('salons.create');
        Route::post('/salons', [SuperAdminController::class, 'storeSalon'])->name('salons.store');
        Route::get('/salons/{salon}', [SuperAdminController::class, 'showSalon'])->name('salons.show');
        Route::get('/salons/{salon}/edit', [SuperAdminController::class, 'editSalon'])->name('salons.edit');
        Route::patch('/salons/{salon}', [SuperAdminController::class, 'updateSalon'])->name('salons.update');
        Route::delete('/salons/{salon}', [SuperAdminController::class, 'destroySalon'])->name('salons.destroy');
        Route::get('/products', [SuperAdminController::class, 'products'])->name('products.index');
        Route::get('/products/{product}', [SuperAdminController::class, 'showProduct'])->name('products.show');
        Route::get('/products/{product}/edit', [SuperAdminController::class, 'editProduct'])->name('products.edit');
        Route::patch('/products/{product}', [SuperAdminController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{product}', [SuperAdminController::class, 'destroyProduct'])->name('products.destroy');
        Route::get('/bookings', [SuperAdminController::class, 'bookings'])->name('bookings.index');
        Route::get('/bookings/{booking}', [SuperAdminController::class, 'showBooking'])->name('bookings.show');
        Route::delete('/bookings/{booking}', [SuperAdminController::class, 'destroyBooking'])->name('bookings.destroy');
        Route::get('/statistics', [SuperAdminController::class, 'getStatistics'])->name('statistics');
        Route::get('/contacts', [ContactController::class, 'superAdminIndex'])->name('contacts.index');
        Route::get('/contacts/{contact}', [ContactController::class, 'superAdminShow'])->name('contacts.show');
        Route::delete('/contacts/{contact}', [ContactController::class, 'superAdminDestroy'])->name('contacts.destroy');
    });
    
    // Salon routes
    Route::resource('salon', SalonController::class);
    
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

// public contact form submission
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// API endpoint to check staff availability
Route::get('/api/staff/{staff}/availability', [BookingController::class, 'checkStaffAvailability'])->name('staff.availability');
