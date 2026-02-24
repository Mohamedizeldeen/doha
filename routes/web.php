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
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportsController;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Language switch route
Route::get('/language/{locale}', function (string $locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('language.switch');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.send-otp');
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('password.verify.form');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('password.verify-otp');
    Route::get('/reset-password-otp', [AuthController::class, 'showResetWithOtp'])->name('password.reset.otp');
    Route::post('/reset-password-otp', [AuthController::class, 'resetWithOtp'])->name('password.update.otp');
});

// Authenticated routes
Route::middleware(['auth', 'active'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Change Password
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
    
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
        Route::post('/salons/{salon}/payment', [SuperAdminController::class, 'recordPayment'])->name('salons.recordPayment');
        Route::post('/salons/{salon}/toggle-status', [SuperAdminController::class, 'toggleSalonStatus'])->name('salons.toggleStatus');
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
        Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
        Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
        Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
        Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');
        Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
        Route::patch('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
        Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
        Route::get('users', [AuthController::class, 'getNotSuperAdminUsers'])->name('users.index');
        Route::delete('users/{user}', [AuthController::class,'destroyUser'])->name('users.destroy');
        
        // Sales user management
        Route::get('sales-users', [SuperAdminController::class, 'salesUsers'])->name('salesUsers.index');
        Route::get('sales-users/create', [SuperAdminController::class, 'createSalesUser'])->name('salesUsers.create');
        Route::post('sales-users', [SuperAdminController::class, 'storeSalesUser'])->name('salesUsers.store');
        Route::get('sales-users/{user}/edit', [SuperAdminController::class, 'editSalesUser'])->name('salesUsers.edit');
        Route::patch('sales-users/{user}', [SuperAdminController::class, 'updateSalesUser'])->name('salesUsers.update');
        Route::delete('sales-users/{user}', [SuperAdminController::class, 'destroySalesUser'])->name('salesUsers.destroy');
    });
    
    // Sales routes (only for sales role)
    Route::middleware('role:sales')->prefix('sales')->name('sales.')->group(function () {
        Route::get('/dashboard', [SalesController::class, 'dashboard'])->name('dashboard');
        Route::get('/salons', [SalesController::class, 'salons'])->name('salons.index');
        Route::get('/salons/create', [SalesController::class, 'createSalon'])->name('salons.create');
        Route::post('/salons', [SalesController::class, 'storeSalon'])->name('salons.store');
        Route::get('/salons/{salon}', [SalesController::class, 'showSalon'])->name('salons.show');
    });
    
    // Salon routes
    Route::resource('salon', SalonController::class);
    
    // Settings routes
        Route::get('/settings/edit', [SalonController::class, 'settingsEdit'])->name('settings.edit');
        Route::get('/settings/show', [SalonController::class, 'settingsShow'])->name('settings.show');
        Route::patch('/settings/update', [SalonController::class, 'settingsUpdate'])->name('settings.update');
    // Nested resources for salon management
    Route::prefix('salon/{salon}')->group(function () {
        // Category routes
        Route::resource('category', CategoryController::class)->except(['show']);
        
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
        Route::patch('booking/{booking}/whatsapp-reminded', [BookingController::class, 'toggleWhatsappReminder'])->name('booking.whatsapp.toggle');
    });
    
    // Admin dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/filter-revenue', [DashboardController::class, 'filterRevenue'])->name('admin.filter-revenue');
    
    // Admin Reports
    Route::get('/admin/reports/{salon}', [ReportsController::class, 'index'])->name('admin.reports');
});

Route::get('/book/{company}', [BookingController::class, 'publicForm'])->name('book');

// Public booking submission
Route::post('/book/{company}', [BookingController::class, 'publicStore'])->name('booking.public.store');

// public contact form submission
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// API endpoint to check staff availability
Route::get('/api/staff/{staff}/availability', [BookingController::class, 'checkStaffAvailability'])->name('staff.availability');

// API endpoint to get available staff for a salon/service/datetime
Route::get('/api/salon/{salon}/available-staff', [BookingController::class, 'getAvailableStaff'])->name('api.available-staff');

// Public blog routes
Route::get('/blogs', [BlogController::class, 'publicIndex'])->name('blogs.public.index');
Route::get('/blogs/{blog}', [BlogController::class, 'publicShow'])->name('blogs.public.show');

// Policy page
Route::view('/policy', 'policy')->name('policy');