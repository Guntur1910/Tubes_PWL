<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function show($id)
    {
        $event = Event::findOrFail($id);

        return view('user.product-detail', compact('event'));
    }
}