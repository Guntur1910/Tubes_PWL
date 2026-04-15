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
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;

// ==========================
// ROOT ROUTE
// ==========================
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('user.home');
    }
    return redirect()->route('login');
});

// ==========================
// AUTH ROUTES (GUEST)
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
// AUTH ROUTES (LOGGED IN)
// ==========================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// ==========================
// ADMIN ROUTES
// ==========================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::resource('events', AdminEventController::class);

    // Scan Ticket
    Route::get('/scan-ticket', [TicketController::class, 'scanPage'])->name('scan-ticket');
    Route::post('/validate-ticket', [TicketController::class, 'validateTicket'])->name('validate-ticket');
});

// ==========================
// ORGANIZER ROUTES (FIXED & CLEAN)
// ==========================
Route::middleware(['auth', 'organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    // Ini WAJIB ke Controller supaya $totalRevenue terisi
    Route::get('/dashboard', [OrganizerDashboardController::class, 'index'])->name('dashboard');
    
    // Resource Event untuk Organizer
    Route::resource('events', EventController::class);
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
    
    // Event Detail
    Route::get('/event/{id}', [EventController::class, 'show'])->name('event');
    
    // Cart & Process
    Route::post('/event/buy', [EventController::class, 'buyTicket'])->name('checkout.process');
    Route::post('/checkout/pay', [HomeController::class, 'payCheckout'])->name('checkout.pay');
    Route::post('/cart/{transaction}/update-quantity', [EventController::class, 'updateQuantity'])->name('cart.update-quantity');
    Route::delete('/cart/{transaction}/delete', [EventController::class, 'deleteFromCart'])->name('cart.delete');

    // Tickets
    Route::get('/tickets', [TicketController::class, 'myTickets'])->name('tickets');
    Route::post('/tickets/generate/{transaction}', [TicketController::class, 'generate'])->name('tickets.generate');
    Route::post('/tickets/join-waiting-list', [TicketController::class, 'joinWaitingList'])->name('tickets.join-waiting-list');

    // Payment
    Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('payment');
    Route::post('/payment/{id}/success', [PaymentController::class, 'success'])->name('payment.success');
});


// ==========================
// PROFILE ROUTES
// ==========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});



Route::middleware(['auth', 'organizer'])->prefix('organizer')->name('organizer.')->group(function () {

        Route::get('/dashboard', [OrganizerDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('events', EventController::class);
});

// ... route lainnya ...

Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
    
    // ✅ Route untuk memproses "Add to Cart" dari halaman detail
    Route::post('/event/buy', [EventController::class, 'buyTicket'])->name('checkout.process');

    // ✅ Route untuk memproses pembayaran final (Place Order) di halaman checkout
    Route::post('/checkout/pay', [HomeController::class, 'payCheckout'])->name('checkout.pay');

    // ✅ Route untuk update quantity tiket di keranjang
    Route::post('/cart/{transaction}/update-quantity', [EventController::class, 'updateQuantity'])->name('cart.update-quantity');

    // ✅ Route untuk hapus tiket dari keranjang
    Route::delete('/cart/{transaction}/delete', [EventController::class, 'deleteFromCart'])->name('cart.delete');

    // 🎫 TICKET MANAGEMENT ROUTES
    Route::get('/tickets', [App\Http\Controllers\TicketController::class, 'myTickets'])->name('tickets');
    Route::post('/tickets/generate/{transaction}', [App\Http\Controllers\TicketController::class, 'generateTickets'])->name('tickets.generate');
    Route::post('/tickets/join-waiting-list', [App\Http\Controllers\TicketController::class, 'joinWaitingList'])->name('tickets.join-waiting-list');

    Route::get('/event/{id}', [EventController::class, 'show'])->name('event');

    // 💳 PAYMENT ROUTES
    Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('payment');
    Route::post('/payment/{id}/success', [PaymentController::class, 'success'])->name('payment.success');
});


Route::get('/transaction/paid/{id}', [TransactionController::class, 'markAsPaid']);

// ========================== QR TICKET  VALIDATION ==========================
Route::post('/tickets/generate/{transaction}', [TicketController::class, 'generate'])
    ->name('user.tickets.generate');

Route::post('/admin/scan', [TicketController::class, 'validateTicket']);

Route::get('/admin/scan', [TicketController::class, 'scanPage']);
Route::post('/admin/scan', [TicketController::class, 'validateTicket']);