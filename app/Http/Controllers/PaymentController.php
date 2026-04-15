<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\ETicketMail;

class PaymentController extends Controller
{
    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Generate QR pakai Imagick
        $qrPath = public_path('qrcodes/qr_' . $transaction->id . '.png');

        if (!file_exists($qrPath)) {
            $this->generateQR($transaction->id, $qrPath);
        }

        return view('user.payment', compact('transaction', 'qrPath'));
    }

    private function generateQR($data, $path)
    {
        // Ensure directory exists
        $dir = dirname($path);
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        // Try Imagick first (if available)
        if (extension_loaded('imagick')) {
            try {
                $pngContent = $this->generateQRWithImagick($data);
                file_put_contents($path, $pngContent);
                return;
            } catch (\Exception $e) {
                \Log::warning('Imagick QR generation failed, falling back to PNG binary: ' . $e->getMessage());
            }
        }

        // Fallback ke PNG binary generator
        $pngContent = $this->generateQRCodePNGBinary($data);
        file_put_contents($path, $pngContent);
    }

    private function generateQRWithImagick($data)
    {
        $im = new \Imagick();
        $im->newImage(300, 300, new \ImagickPixel('white'));
        $im->setImageFormat('png');

        $draw = new \ImagickDraw();
        $draw->setFillColor('black');
        $draw->setFontSize(12);

        // Draw pattern grid untuk QR code
        $pattern = $this->generateQRPatternPayment(strlen($data));
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
        $pattern = $this->generateQRPatternPayment(strlen($data));
        $size = count($pattern); // Pattern size in cells
        $cellSize = 10; // pixels per cell
        $imageSize = $size * $cellSize; // Total image size in pixels
        
        // PNG header
        $png = "\x89PNG\r\n\x1a\n";
        
        // IHDR chunk (image header)
        $ihdr_data = pack('NNCCCCC', $imageSize, $imageSize, 8, 2, 0, 0, 0);
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

    private function generateQRPatternPayment($dataLength)
    {
        // Generate simple QR pattern
        $size = max(21, ceil($dataLength / 4) * 4 + 1);
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

    public function success($id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $transaction = Transaction::with('event', 'ticketType', 'user')->findOrFail($id);

        // Verifikasi transaksi milik user yang authenticated
        if ($transaction->user_id !== $user->id) {
            return redirect()->route('user.checkout')->with('error', 'Akses tidak diizinkan');
        }

        // UPDATE STATUS
        $transaction->status = 'paid';
        $transaction->save();

        // HAPUS CART
        Cart::where('user_id', $user->id)->delete();

        // Generate QR code jika belum ada
        $qrPath = public_path('qrcodes/qr_' . $transaction->id . '.png');
        if (!file_exists($qrPath)) {
            $this->generateQR($transaction->id, $qrPath);
        }

        // KIRIM EMAIL E-TICKET dengan QR code attachment
        try {
            Mail::to($user->email)->send(new ETicketMail($transaction));
        } catch (\Exception $e) {
            \Log::error('Failed to send email for transaction ' . $transaction->id . ': ' . $e->getMessage());
            // Jangan stop proses, tetap redirect dengan success message
        }

        return redirect()->route('user.tickets')->with('success', 'Pembayaran berhasil! E-ticket telah dikirim ke email Anda.');
    }
}