<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GasRequestController;
use App\Http\Controllers\HeadOfficeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OutletManagerController;
use App\Http\Controllers\TokenController;

Route::get('/', function () {
    return view('home');
});

// Authentication Routes
Auth::routes();

// Guest Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::get('/home', function () {
    return view('home'); // Everyone, including logged-in users, stays on home
})->name('home');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'deleteAccount'])->name('profile.delete');

    // Gas Request Routes
    Route::get('/gasrequest', [GasRequestController::class, 'index'])->name('gasrequest');
    Route::post('/gasrequest', [GasRequestController::class, 'store'])->name('gasrequest.store');

    // Head Office Routes
    Route::get('/headoffice', [HeadOfficeController::class, 'index'])->name('headoffice');
    Route::post('/headoffice/deliveries', [HeadOfficeController::class, 'storeDelivery'])->name('dispatch.addDelivery');

    // Tokens Routes
    Route::get('/tokens', [TokenController::class, 'index'])->name('tokens.index');
    Route::get('/tokens/{id}', [TokenController::class, 'details'])->name('tokens.details');
});

// Role-Based Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admindashboard', [AdminController::class, 'index'])->name('admindashboard')->middleware('role:admin');

    // Outlet Manager Dashboard
    Route::get('/outletmanager', [OutletManagerController::class, 'index'])->name('outletmanager')->middleware('role:outlet_manager');
    Route::get('/outletmanager/approve/{id}', [OutletManagerController::class, 'approveRequest'])->name('outletmanager.approve');
    Route::get('/outletmanager/deny/{id}', [OutletManagerController::class, 'denyRequest'])->name('outletmanager.deny'); 
    Route::post('/outletmanager/receive-delivery/{id}', [OutletManagerController::class, 'receiveDelivery'])->name('outletmanager.receiveDelivery');   
    Route::post('/outletmanager/extend-token/{id}', [OutletManagerController::class, 'extendToken'])->name('outletmanager.extendToken')->middleware('auth');
    Route::post('/outletmanager/complete-token/{id}', [OutletManagerController::class, 'completeToken'])->name('outletmanager.completeToken');
    Route::post('/outletmanager/fail-token/{id}', [OutletManagerController::class, 'failToken'])->name('outletmanager.failToken');
});

// Admin Role Assignment & Business Verification
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/admin/assign-role', [AdminController::class, 'assignRole'])->name('admin.assignRole');
    Route::post('/admin/verify-business/{id}', [AdminController::class, 'verifyBusiness'])->name('admin.verifyBusiness'); // ✅ New route added
});

// Static Pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
