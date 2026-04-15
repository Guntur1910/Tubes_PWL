<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class OrganizerDashboardController extends Controller
{
    public function index()
    {
        $organizerId = auth::id();

        // Event milik organizer
        $events = \App\Models\Event::where('organizer_id', $organizerId)->get();

        $eventIds = $events->pluck('id');

        $totalEvents = $events->count();

        $totalRevenue = \App\Models\Transaction::whereIn('event_id', $eventIds)
            ->where('status', 'paid')
            ->sum('total_amount');

        $totalTicket = \App\Models\Transaction::whereIn('event_id', $eventIds)
            ->where('status', 'paid')
            ->sum('quantity');

        $latestTransactions = \App\Models\Transaction::whereIn('event_id', $eventIds)
            ->latest()
            ->take(5)
            ->get();

        return view('organizer.dashboard', compact(
            'events',
            'totalEvents',
            'totalRevenue',
            'totalTicket',
            'latestTransactions'
        ));
    }
}