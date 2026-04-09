<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Organizer\OrganizerDashboardController;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('user.home')
        : redirect()->route('login');
});


// ==========================
// AUTH ROUTES
// ==========================
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/user/register', [AuthController::class, 'showRegister'])->name('user.register');
    Route::post('/user/register', [AuthController::class, 'register']);

    Route::get('/admin/register', [AdminRegisterController::class, 'showForm'])->name('admin.register');
    Route::post('/admin/register', [AdminRegisterController::class, 'register']);
});


// ==========================
// LOGOUT
// ==========================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


// ==========================
// ADMIN ROUTES
// ==========================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

});


// ==========================
// USER ROUTES
// ==========================
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
    Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');

    // ✅ EVENT DETAIL
    Route::get('/event/{id}', [EventController::class, 'show'])->name('event');

});


// ==========================
// PROFILE ROUTES
// ==========================
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

});

Route::middleware(['auth', 'organizer'])->prefix('organizer')->name('dashboard')->group(function () {

        Route::get('/dashboard', [OrganizerDashboardController::class, 'index'])
            ->name('organizer.dashboard');

        Route::resource('events', EventController::class);
});