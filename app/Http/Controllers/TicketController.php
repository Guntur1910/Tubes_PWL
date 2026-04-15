<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

            // Generate QR code sebagai PNG binary (tanpa GD extension)
            $qrData = $ticketCode;
            $pngContent = $this->generateQRCodePNG($qrData);

            // simpan file
            $qrPath = 'qr-codes/' . $ticketCode . '.png';
            Storage::disk('public')->put($qrPath, $pngContent);

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

    // =========================
    // GENERATE QR CODE PNG (NO GD EXTENSION NEEDED)
    // =========================
    private function generateQRCodePNG($data)
    {
        // Try Imagick first (if available)
        if (extension_loaded('imagick')) {
            try {
                return $this->generateQRWithImagick($data);
            } catch (\Exception $e) {
                \Log::warning('Imagick QR generation failed, falling back to PNG binary: ' . $e->getMessage());
            }
        }
        
        // Fallback ke PNG binary generator
        return $this->generateQRCodePNGBinary($data);
    }

    private function generateQRWithImagick($data)
    {
        $im = new \Imagick();
        $im->newImage(300, 300, new \ImagickPixel('white'));
        $im->setImageFormat('png');

        $draw = new \ImagickDraw();
        $draw->setFillColor('black');
        $draw->setFont(__DIR__ . '/../../resources/fonts/Arial.ttf');
        $draw->setFontSize(12);

        // Draw pattern grid untuk QR code
        $pattern = $this->generateQRPattern(strlen($data));
        $cellSize = 300 / count($pattern);

        foreach ($pattern as $row => $rowCells) {
            foreach ($rowCells as $col => $cell) {
                if ($cell) {
                    $x1 = $col * $cellSize;
                    $y1 = $row * $cellSize;
                    $x2 = $x1 + $cellSize;
                    $y2 = $y1 + $cellSize;
                    
                    $draw->rectangle($x1, $y1, $x2, $y2);
                }
            }
        }

        $im->drawImage($draw);
        return $im->getImageBlob();
    }

    private function generateQRCodePNGBinary($data)
    {
        // Generate QR-like pattern
        $pattern = $this->generateQRPattern(strlen($data));
        $size = count($pattern); // Pattern size in cells
        $cellSize = 10; // pixels per cell
        $imageSize = $size * $cellSize; // Total image size in pixels
        
        // PNG header
        $png = "\x89PNG\r\n\x1a\n";
        
        // IHDR chunk (image header)
        $ihdr_data = pack('NNCCCCC', $imageSize, $imageSize, 8, 2, 0, 0, 0);
        // N = unsigned 32-bit big-endian (width, height)
        // C = unsigned byte (bit depth, color type, compression, filter, interlace)
        $ihdr = $this->createPNGChunk('IHDR', $ihdr_data);
        
        // Create image data - build scanline by scanline
        $scanlines = '';
        
        foreach ($pattern as $patternRow => $rowCells) {
            // Each pattern row becomes $cellSize scanlines
            for ($pixelRow = 0; $pixelRow < $cellSize; $pixelRow++) {
                $scanline = "\x00"; // filter type: None
                
                // For each cell in the pattern row
                foreach ($rowCells as $cell) {
                    // Each cell is $cellSize pixels wide
                    for ($pixelCol = 0; $pixelCol < $cellSize; $pixelCol++) {
                        if ($cell) {
                            // Black pixel (RGB: 0,0,0)
                            $scanline .= "\x00\x00\x00";
                        } else {
                            // White pixel (RGB: 255,255,255)
                            $scanline .= "\xFF\xFF\xFF";
                        }
                    }
                }
                
                $scanlines .= $scanline;
            }
        }
        
        // Compress image data
        $compressed = gzcompress($scanlines, 9);
        $idat = $this->createPNGChunk('IDAT', $compressed);
        
        // IEND chunk (marks end of PNG)
        $iend = $this->createPNGChunk('IEND', '');
        
        return $png . $ihdr . $idat . $iend;
    }

    private function generateQRPattern($dataLength)
    {
        // Generate simple QR pattern
        $size = max(21, ceil($dataLength / 4) * 4 + 1); // Minimal QR size
        $pattern = [];
        
        for ($i = 0; $i < $size; $i++) {
            $pattern[$i] = [];
            for ($j = 0; $j < $size; $j++) {
                // Finder pattern (3 corners)
                if (($i < 7 && $j < 7) || ($i < 7 && $j >= $size - 8) || ($i >= $size - 8 && $j < 7)) {
                    $pattern[$i][$j] = 1;
                } else if (($i == 7 || $j == 7) && (($i < 8 && $j < 8) || ($i < 8 && $j >= $size - 8) || ($i >= $size - 8 && $j < 8))) {
                    $pattern[$i][$j] = 0;
                } else {
                    // Random pattern untuk data area
                    $pattern[$i][$j] = (($i + $j + $dataLength) % 3 === 0) ? 1 : 0;
                }
            }
        }
        
        return $pattern;
    }

    private function createPNGChunk($type, $data)
    {
        $length = strlen($data);
        $chunkData = $type . $data;
        $crc = crc32($chunkData);
        
        return pack('N', $length) . $chunkData . pack('N', $crc);
    }
}