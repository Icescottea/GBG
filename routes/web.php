<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GasRequestController;
use App\Http\Controllers\HeadOfficeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Gas Request Routes
    Route::get('/gasrequest', [GasRequestController::class, 'index'])->name('gasrequest');
    Route::post('/gasrequest', [GasRequestController::class, 'store'])->name('gasrequest.store');

    // Head Office Routes
    Route::get('/headoffice', [HeadOfficeController::class, 'index'])->name('headoffice');
    Route::post('/headoffice/deliveries', [HeadOfficeController::class, 'storeDelivery'])->name('headoffice.storeDelivery');
    Route::post('/headoffice/deliveries', [HeadOfficeController::class, 'storeDelivery'])->name('dispatch.addDelivery');
});

// Role-Based Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admindashboard', [AdminController::class, 'index'])->name('admindashboard')->middleware('role:admin');
    Route::get('/outletmanager', function () {
        return view('outletmanager');
    })->name('outletmanager')->middleware('role:outlet_manager');
});

// Admin Role Assignment
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/admin/assign-role', [AdminController::class, 'assignRole'])->name('admin.assignRole');
});

// Static Pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
