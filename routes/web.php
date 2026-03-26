<?php

use Illuminate\Support\Facades\Route;

// ── AUTH ROUTES ──
use App\Http\Controllers\AuthController; 
use Illuminate\Support\Facades\Auth;

// Landing: guest sees login (default), authenticated user redirect to home.
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('user.home')
        : redirect()->route('login');
});

// Guest only (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

// Auth only (sudah login)
Route::middleware('auth')->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');
});

use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});



use App\Http\Controllers\User\HomeController;
/*
|--------------------------------------------------------------------------
| User Routes - Template Essence
|--------------------------------------------------------------------------
| User pages hanya bisa diakses setelah login.
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('user')->name('user.')->group(function () {

    // Halaman utama setelah login
    Route::get('/home',    [HomeController::class, 'index'])->name('home');
    Route::get('/shop',    [HomeController::class, 'shop'])->name('shop');
    Route::get('/product/{id}', [HomeController::class, 'product'])->name('product');
    Route::get('/blog',    [HomeController::class, 'blog'])->name('blog');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/checkout',[HomeController::class, 'checkout'])->name('checkout');

    // Cart (tambahkan nanti sesuai kebutuhan)
    // Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    // Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

});

use App\Http\Controllers\admin\AdminRegisterController;

Route::get('/register', [AdminRegisterController::class, 'showForm'])->name('admin.register');
Route::post('/register', [AdminRegisterController::class, 'register']);

// Register ADMIN (sekali, pakai AdminRegisterController)
Route::get('/register', [AdminRegisterController::class, 'showForm'])->name('admin.register');
Route::post('/register', [AdminRegisterController::class, 'register']);

// Register USER BIASA (pakai AuthController)
Route::get('/user/register', [AuthController::class, 'showRegister'])->name('user.register');
Route::post('/user/register', [AuthController::class, 'register']);