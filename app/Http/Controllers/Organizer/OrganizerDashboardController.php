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
        $organizerId = Auth::id();

        $eventIds = Event::where('organizer_id', $organizerId)
                    ->pluck('id')
                    ->toArray();

        $totalEvent = count($eventIds);

        $totalRevenue = Transaction::whereIn('event_id', $eventIds)
            ->where('status', 'paid')
            ->sum('total_amount');

        $totalTicket = Transaction::whereIn('event_id', $eventIds)
            ->where('status', 'paid')
            ->sum('quantity');

        return view('organizer.dashboard', compact(
            'totalEvent',
            'totalRevenue',
            'totalTicket'
        ));
    }
}