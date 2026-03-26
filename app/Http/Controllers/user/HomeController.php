<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('user.home', [
            'heroTitle'       => 'New Collection',
            'heroSubtitle'    => 'New Season',
            'popularProducts' => [], // Isi dengan: Product::popular()->take(8)->get()
        ]);
    }

    public function shop()
    {
        return view('user.shop', [
            'products' => [], // Isi dengan: Product::paginate(12)
        ]);
    }

    public function product($id)
    {
        return view('user.product', [
            'product' => [], // Isi dengan: Product::findOrFail($id)
        ]);
    }

    public function blog()
    {
        return view('user.blog', [
            'posts' => [], // Isi dengan: Post::paginate(6)
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
