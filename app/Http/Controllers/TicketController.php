<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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

    // Generate tickets setelah pembayaran berhasil
    public function generateTickets(Transaction $transaction)
    {
        // Pastikan transaction milik user dan status paid
        if ($transaction->user_id !== Auth::id() || $transaction->status !== 'paid') {
            abort(403);
        }

        // Cek apakah tickets sudah pernah di-generate
        if ($transaction->tickets()->count() > 0) {
            return redirect()->route('user.tickets')->with('info', 'Tickets sudah di-generate sebelumnya');
        }

        // Generate individual tickets berdasarkan quantity
        for ($i = 0; $i < $transaction->quantity; $i++) {
            $ticketCode = 'TKT-' . strtoupper(substr(md5(uniqid($transaction->id . $i)), 0, 8));

            // Generate QR Code
            $qrCode = new QrCode($ticketCode);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            // Simpan QR code ke storage
            $qrPath = 'qr-codes/' . $ticketCode . '.png';
            Storage::disk('public')->put($qrPath, $result->getString());

            // Buat ticket record
            Ticket::create([
                'transaction_id' => $transaction->id,
                'ticket_code' => $ticketCode,
                'qr_code_path' => $qrPath,
                'status' => 'unused'
            ]);
        }

        // Kirim email dengan tickets
        $this->sendTicketEmail($transaction);

        return redirect()->route('user.tickets')->with('success', 'E-tickets berhasil di-generate dan dikirim ke email Anda');
    }

    // Tampilkan semua tickets user
    public function myTickets()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->where('status', 'paid')
            ->with(['event', 'ticketType', 'tickets'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.tickets', compact('transactions'));
    }

    // Halaman scan tiket (untuk admin/organizer)
    public function scanPage()
    {
        return view('admin.scan-ticket');
    }

    // Validasi tiket via AJAX (scan simulation)
    public function validateTicket(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string'
        ]);

        $ticket = Ticket::where('ticket_code', $request->ticket_code)
            ->with(['transaction.event', 'transaction.ticketType'])
            ->first();

        if (!$ticket) {
            return response()->json([
                'valid' => false,
                'message' => 'Tiket tidak ditemukan'
            ]);
        }

        if ($ticket->status === 'used') {
            return response()->json([
                'valid' => false,
                'message' => 'Tiket sudah digunakan pada ' . $ticket->used_at->format('d/m/Y H:i'),
                'ticket' => $ticket
            ]);
        }

        if ($ticket->status === 'cancelled') {
            return response()->json([
                'valid' => false,
                'message' => 'Tiket telah dibatalkan',
                'ticket' => $ticket
            ]);
        }

        // Mark as used
        $ticket->markAsUsed();

        return response()->json([
            'valid' => true,
            'message' => 'Tiket valid! Selamat menikmati event.',
            'ticket' => $ticket
        ]);
    }

    // Join waiting list
    public function joinWaitingList(Request $request)
    {
        $request->validate([
            'ticket_type_id' => 'required|exists:ticket_type,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $ticketType = TicketType::findOrFail($request->ticket_type_id);

        // Cek apakah masih ada quota
        $availableQuota = $ticketType->quota - $ticketType->sold;
        if ($availableQuota >= $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Masih ada tiket tersedia, silakan langsung beli'
            ]);
        }

        // Cek apakah user sudah join waiting list untuk ticket type ini
        $existingWaitingList = WaitingList::where('user_id', Auth::id())
            ->where('ticket_type_id', $request->ticket_type_id)
            ->where('status', 'waiting')
            ->first();

        if ($existingWaitingList) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah terdaftar dalam waiting list untuk kategori tiket ini'
            ]);
        }

        // Join waiting list
        WaitingList::create([
            'user_id' => Auth::id(),
            'ticket_type_id' => $request->ticket_type_id,
            'quantity' => $request->quantity,
            'status' => 'waiting',
            'expires_at' => now()->addDays(30) // Expire dalam 30 hari
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil bergabung ke waiting list. Anda akan diberitahu jika tiket tersedia.'
        ]);
    }

    // Kirim email dengan tickets
    private function sendTicketEmail(Transaction $transaction)
    {
        try {
            Mail::to($transaction->user->email)->send(new TicketEmail($transaction));
        } catch (\Exception $e) {
            // Log error tapi jangan hentikan proses
            \Log::error('Failed to send ticket email: ' . $e->getMessage());
        }
    }
}
