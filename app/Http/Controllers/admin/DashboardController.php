<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEvent = Event::count();
        $totalUser = User::where('role','user')->count();

        $totalTicketSold = Transaction::where('status','paid')
                            ->sum('quantity');

        $totalRevenue = Transaction::where('status','paid')
                            ->sum('total_amount');

        $latestEvents = Event::latest()->take(5)->get();
        $latestTransactions = Transaction::with('user','event')
                                ->latest()
                                ->take(5)
                                ->get();

        $monthlyData = Transaction::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->where('status','paid')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyLabels = $monthlyData->pluck('month');
        $monthlyRevenue = $monthlyData->pluck('total');

        return view('admin.dashboard', compact(
            'totalEvent',
            'totalUser',
            'totalTicketSold',
            'totalRevenue',
            'latestEvents',
            'latestTransactions',
            'monthlyLabels',
            'monthlyRevenue'
        ));
    }
}   