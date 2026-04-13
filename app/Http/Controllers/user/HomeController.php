<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua event terbaru
        $events = Event::latest()->take(8)->get();
        $popularProducts = Event::latest()->take(6)->get();
        $popularProducts = Event::orderBy('created_at', 'desc')->paginate(6);
        return view('user.home', compact('popularProducts'));
        return view('user.home', [
            'heroTitle'       => 'Live Concert 2026',
            'heroSubtitle'    => 'Don\'t Miss It',
            'popularProducts' => $events, // kita tetap pakai nama ini biar blade gak perlu banyak diubah
            'heroEventId'     => $events->first()->id ?? 1,
        ]);
    }

    public function shop()
    {
        // Ambil semua event (bisa ditambah pagination nantinya)
        $events = Event::all() ?? []; 
        return view('user.shop', compact('events'));
    }

    // 🔥 HAPUS function product() kalau sudah pakai EventController
    // karena detail event sekarang lewat /event/{id}

    public function blog()
    {
        return view('user.blog', [
            'posts' => [],
        ]);
    }

    public function contact()
    {
        return view('user.contact');
    }

    public function checkout()
    {
        // Mengambil semua transaksi user yang statusnya masih 'pending' (bertindak sebagai keranjang)
        $cart = Transaction::with('event', 'ticketType')
                ->where('user_id', Auth::id())
                ->where('status', 'pending')
                ->get();

        // Hitung total harga semua tiket di keranjang
        $total = $cart->sum('total_amount');

        return view('user.checkout', compact('cart', 'total'));
    }

    // Simulasi Pembayaran (Update status transaksi)
    public function payCheckout(Request $request)
    {
        // Ambil semua transaksi pending user
        $pendingTransactions = Transaction::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->with(['event', 'ticketType'])
            ->get();

        if ($pendingTransactions->isEmpty()) {
            return redirect()->route('user.checkout')->with('error', 'Tidak ada item di keranjang');
        }

        // Update status menjadi paid
        Transaction::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->update(['status' => 'paid']);

        // Auto-generate tickets untuk setiap transaksi
        $ticketController = new \App\Http\Controllers\TicketController();
        foreach ($pendingTransactions as $transaction) {
            try {
                $ticketController->generateTickets($transaction);
            } catch (\Exception $e) {
                \Log::error('Failed to generate tickets for transaction ' . $transaction->id . ': ' . $e->getMessage());
            }
        }

        return redirect()->route('user.tickets')->with('success', 'Pembayaran berhasil! E-tickets telah dikirim ke email Anda.');
    }
}