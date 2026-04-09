<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // DETAIL EVENT (untuk user)
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('user.product-detail', compact('event'));
    }

    // SIMPAN EVENT (untuk organizer)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'location' => 'required',
            'quota' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
            'quota' => $request->quota,
            'price' => $request->price,
            'organizer_id' => auth()->id(), // WAJIB
        ]);

        return redirect()->back()->with('success', 'Event berhasil dibuat!');
    }
}