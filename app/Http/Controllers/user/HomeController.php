<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua event terbaru
        $events = Event::latest()->take(8)->get();
        $popularProducts = Event::latest()->take(6)->get();
        $popularProducts = Event::orderBy('created_at', 'desc')->paginate(6);
        $heroEvents = Event::latest()->take(5)->get(); // ambil beberapa event buat hero

            return view('user.home', compact('popularProducts', 'heroEvents'));        return view('user.home', [
            'heroTitle'       => 'Live Concert 2026',
            'heroSubtitle'    => 'Don\'t Miss It',
            'popularProducts' => $events, // kita tetap pakai nama ini biar blade gak perlu banyak diubah
            'heroEventId'     => $events->first()->id ?? 1,
        ]);
    }

    public function shop()
    {
        $events = Event::paginate(12);

        return view('user.shop', [
            'products' => $events,
        ]);
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
        return view('user.checkout', [
            'cart' => session('cart', []),
        ]);
    }
}