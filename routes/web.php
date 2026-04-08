<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\User\HomeController;

/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('user.home')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH - GUEST ONLY
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register USER biasa
    Route::get('/user/register', [AuthController::class, 'showRegister'])->name('user.register');
    Route::post('/user/register', [AuthController::class, 'register']);

    // Register ADMIN
    Route::get('/admin/register', [AdminRegisterController::class, 'showForm'])->name('admin.register');
    Route::post('/admin/register', [AdminRegisterController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| AUTH - LOGOUT
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
    Route::get('/product/{id}', [HomeController::class, 'product'])->name('product');
    Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');

});