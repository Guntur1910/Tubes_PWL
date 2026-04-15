<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // DETAIL EVENT (untuk user)
    public function show($id)
    {
        $event = Event::findOrFail($id);

        return view('user.product-detail', compact('event'));
    }

    // FUNGSI BARU: SIMPAN KE KERANJANG
    public function buyTicket(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_type_id' => 'required|exists:ticket_type,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $event = Event::findOrFail($request->event_id);
        $ticketType = TicketType::findOrFail($request->ticket_type_id);

        Transaction::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'ticket_type_id' => $ticketType->id,
            'quantity' => $request->quantity,
            'total_amount' => $ticketType->price * $request->quantity,
            'status' => 'pending',
        ]);

        return redirect()->route('user.checkout')->with('success', 'Tiket berhasil ditambahkan ke keranjang!');
    }

    // UPDATE QUANTITY TIKET DI KERANJANG
    public function updateQuantity(Request $request, $transactionId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $transaction = Transaction::findOrFail($transactionId);

        // Pastikan user hanya bisa edit transaksi mereka sendiri
        if ($transaction->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Update quantity dan total amount
        $transaction->quantity = $request->quantity;
        $transaction->total_amount = $transaction->ticketType->price * $request->quantity;
        $transaction->save();

        return response()->json([
            'success' => true,
            'message' => 'Jumlah tiket berhasil diperbarui',
            'quantity' => $transaction->quantity,
            'total_amount' => $transaction->total_amount,
        ]);
    }

    // HAPUS TIKET DARI KERANJANG
    public function deleteFromCart($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);

        // Pastikan user hanya bisa menghapus transaksi mereka sendiri
        if ($transaction->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $transaction->delete();

        return redirect()->route('user.checkout')->with('success', 'Tiket berhasil dihapus dari keranjang');
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
            'organizer_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Event berhasil dibuat!');
    }
}
