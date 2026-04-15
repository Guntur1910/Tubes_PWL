<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    // =========================
    // STORE EVENT
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required|in:konser,festival,theater',
            'description' => 'required',
            'date' => 'required|date',
            'location' => 'required',
            'quota' => 'required|integer',
            'price' => 'required|numeric',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'tickets' => 'required|array'
        ]);

        // =========================
        // UPLOAD POSTER
        // =========================
        $posterPath = null;

        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('events', $filename, 'public');

            $posterPath = 'events/' . $filename;
        }

        // =========================
        // CREATE EVENT
        // =========================
        $event = Event::create([
            'organizer_id' => Auth::id() ?? 1,
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
            'quota' => $request->quota,
            'price' => $request->price,
            'poster' => $posterPath,
        ]);

        // =========================
        // SAVE TICKET TYPES
        // =========================
        foreach ($request->tickets as $ticket) {
            if (!empty($ticket['name'])) {
                TicketType::create([
                    'event_id' => $event->id,
                    'name' => $ticket['name'],
                    'description' => $ticket['description'] ?? null,
                    'price' => $ticket['price'],
                    'quota' => $ticket['quota'],
                ]);
            }
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat!');
    }

    public function edit(Event $event)
    {
        $event->load('ticketTypes');
        return view('admin.events.edit', compact('event'));
    }

    // =========================
    // UPDATE EVENT
    // =========================
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required|in:konser,festival,theater',
            'description' => 'required',
            'date' => 'required|date',
            'location' => 'required',
            'quota' => 'required|integer',
            'price' => 'required|numeric',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'tickets' => 'nullable|array'
        ]);

        // =========================
        // HANDLE POSTER
        // =========================
        if ($request->hasFile('poster')) {

            $file = $request->file('poster');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('events', $filename, 'public');

            // hapus lama
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }

            $posterPath = 'events/' . $filename;

        } else {
            $posterPath = $event->poster;
        }

        // =========================
        // UPDATE EVENT
        // =========================
        $event->update([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
            'quota' => $request->quota,
            'price' => $request->price,
            'poster' => $posterPath,
        ]);

        // =========================
        // SYNC TICKET TYPES
        // =========================
        $existingIds = $event->ticketTypes->pluck('id')->toArray();
        $submittedIds = [];

        foreach ($request->tickets ?? [] as $ticket) {

            // UPDATE
            if (!empty($ticket['id'])) {

                $submittedIds[] = $ticket['id'];

                TicketType::where('id', $ticket['id'])->update([
                    'name' => $ticket['name'],
                    'description' => $ticket['description'] ?? null,
                    'price' => $ticket['price'],
                    'quota' => $ticket['quota'],
                ]);

            } else {
                // CREATE BARU
                $new = TicketType::create([
                    'event_id' => $event->id,
                    'name' => $ticket['name'],
                    'description' => $ticket['description'] ?? null,
                    'price' => $ticket['price'],
                    'quota' => $ticket['quota'],
                ]);

                $submittedIds[] = $new->id;
            }
        }

        // DELETE YANG DIHAPUS DI FORM
        $toDelete = array_diff($existingIds, $submittedIds);

        if (!empty($toDelete)) {
            TicketType::whereIn('id', $toDelete)->delete();
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Event & ticket berhasil diupdate!');
    }

    public function destroy(Event $event)
    {
        // hapus poster
        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        // hapus ticket types
        $event->ticketTypes()->delete();

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}