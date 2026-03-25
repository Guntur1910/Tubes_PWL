<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Kirim data ke view
        // Ganti dengan query database sesuai kebutuhan project kamu

        return view('admin.dashboard', [
            'topSales'      => 'Johanna Doe',
            'bestSeller'    => 'Produk Unggulan',
            'mostCommented' => 'Artikel Populer',
            'products'      => [], // Isi dengan: Product::latest()->take(5)->get()
        ]);
    }
} 
