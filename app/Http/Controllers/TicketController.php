<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

use App\Models\Transaction;
use App\Models\Ticket;
use App\Models\WaitingList;
use App\Models\TicketType;
use App\Mail\TicketEmail;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================
    // GENERATE TICKETS + QR
    // =========================
    public function generateTickets(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id() || $transaction->status !== 'paid') {
            abort(403);
        }

        if ($transaction->tickets()->count() > 0) {
            return redirect()->route('user.tickets')
                ->with('info', 'Tickets sudah pernah di-generate');
        }

        $qty = $transaction->quantity;

        for ($i = 0; $i < $qty; $i++) {

            // ✅ generate code unik
            do {
                $ticketCode = 'TKT-' . strtoupper(Str::random(8));
            } while (Ticket::where('ticket_code', $ticketCode)->exists());

            $qrData = $ticketCode;

            // 🔥 FIX QR (PALING AMAN)
            $qrCode = new QrCode($qrData);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            // simpan file
            $qrPath = 'qr-codes/' . $ticketCode . '.png';
            Storage::disk('public')->put($qrPath, $result->getString());

            // simpan DB
            Ticket::create([
                'transaction_id' => $transaction->id,
                'ticket_code' => $ticketCode,
                'qr_code_path' => $qrPath,
                'status' => 'unused'
            ]);
        }

        $this->sendTicketEmail($transaction);

        return redirect()->route('user.tickets')
            ->with('success', 'E-ticket berhasil dibuat!');
    }

    // =========================
    // LIST TICKETS USER
    // =========================
    public function myTickets()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->where('status', 'paid')
            ->with(['event', 'ticketType', 'tickets'])
            ->latest()
            ->get();

        return view('user.tickets', compact('transactions'));
    }

    // =========================
    // SCAN PAGE
    // =========================
    public function scanPage()
    {
        return view('admin.scan-ticket');
    }

    // =========================
    // VALIDATE TICKET
    // =========================
    public function validateTicket(Request $request)
    {
    $request->validate([
        'ticket_code' => 'required|string'
    ]);

    $ticket = Ticket::where('ticket_code', $request->ticket_code)->first();

    // ❌ tiket tidak ditemukan
    if (!$ticket) {
        return response()->json([
            'valid' => false,
            'message' => 'Tiket tidak ditemukan'
        ]);
    }

    // ❌ sudah dipakai
    if ($ticket->status === 'used') {
        return response()->json([
            'valid' => false,
            'message' => 'Tiket sudah digunakan pada ' . $ticket->used_at
        ]);
    }

    // ❌ dibatalkan
    if ($ticket->status === 'cancelled') {
        return response()->json([
            'valid' => false,
            'message' => 'Tiket dibatalkan'
        ]);
    }

    // ✅ VALID → ubah status
    $ticket->status = 'used';
    $ticket->used_at = now();
    $ticket->save();

    return response()->json([
        'valid' => true,
        'message' => 'Tiket valid ✅',
        'ticket' => $ticket
    ]);
}

    // =========================
    // WAITING LIST
    // =========================
    public function joinWaitingList(Request $request)
    {
        $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $ticketType = TicketType::findOrFail($request->ticket_type_id);

        $available = $ticketType->quota - $ticketType->sold;

        if ($available >= $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket masih tersedia'
            ]);
        }

        $exists = WaitingList::where('user_id', Auth::id())
            ->where('ticket_type_id', $request->ticket_type_id)
            ->where('status', 'waiting')
            ->first();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Sudah masuk waiting list'
            ]);
        }

        WaitingList::create([
            'user_id' => Auth::id(),
            'ticket_type_id' => $request->ticket_type_id,
            'quantity' => $request->quantity,
            'status' => 'waiting',
            'expires_at' => now()->addDays(30)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil masuk waiting list'
        ]);
    }

    // =========================
    // EMAIL
    // =========================
    private function sendTicketEmail(Transaction $transaction)
    {
        try {
            Mail::to($transaction->user->email)
                ->send(new TicketEmail($transaction));
        } catch (\Exception $e) {
            \Log::error('Email gagal: ' . $e->getMessage());
        }
    }
}