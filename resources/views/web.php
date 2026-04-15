<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes - Admin
|--------------------------------------------------------------------------
|
| Semua route admin dilindungi middleware 'auth'
| Akses hanya untuk user yang sudah login
|
*/

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Route Admin (dilindungi auth)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tambahkan route lain di sini:
    // Route::resource('users', UserController::class);
    // Route::resource('products', ProductController::class);

});

// Route Auth (bawaan Laravel Breeze/UI)
// Jika belum install auth, jalankan: php artisan breeze:install
require __DIR__.'/auth.php';

