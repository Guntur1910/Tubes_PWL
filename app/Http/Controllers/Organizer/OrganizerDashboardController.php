<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction; // Sesuaikan dengan nama model transaksi kamu
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganizerDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Statistik Utama
        $totalEvents = Event::where('organizer_id', $userId)->count();
        
        // Menghitung total tiket terjual dari event milik organizer ini
        $totalTicket = Transaction::whereHas('event', function($query) use ($userId) {
            $query->where('organizer_id', $userId);
        })->where('status', 'paid')->sum('quantity');

        // Menghitung total revenue
        $totalRevenue = Transaction::whereHas('event', function($query) use ($userId) {
            $query->where('organizer_id', $userId);
        })->where('status', 'paid')->sum('total_amount');

        // 2. Data untuk Grafik Transaksi (7 Hari Terakhir)
        $chartData = Transaction::whereHas('event', function($query) use ($userId) {
                $query->where('organizer_id', $userId);
            })
            ->where('status', 'paid')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(7)
            ->get();

        // 3. Event Performance (Analitik per Event)
        $events = Event::where('organizer_id', $userId)
            ->withCount(['transactions as tickets_sold' => function($query) {
                $query->where('status', 'paid')->select(DB::raw('sum(quantity)'));
            }])
            ->withSum(['transactions as revenue' => function($query) {
                $query->where('status', 'paid');
            }], 'total_amount')
            ->get();

        return view('organizer.dashboard', compact(
            'totalEvents', 
            'totalTicket', 
            'totalRevenue', 
            'events',
            'chartData'
        ));
    }
}