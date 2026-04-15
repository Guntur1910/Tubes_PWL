<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // This controller is deprecated for organizer dashboard.
        // The active organizer dashboard route uses OrganizerDashboardController@index.
        return view('organizer.dashboard');
    }
}