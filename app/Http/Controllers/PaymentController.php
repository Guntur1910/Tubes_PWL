<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $im = new \Imagick();
        $im->newImage(300, 300, new \ImagickPixel('white'));

        $draw = new \ImagickDraw();
        $draw->setFillColor('black');
        $draw->setFontSize(20);

        // Simulasi QR (text jadi QR style sederhana)
        $im->annotateImage($draw, 20, 150, 0, "QR-$data");

        $im->setImageFormat("png");
        $im->writeImage($path);
    }

    public function success($id)
    {
        $transaction = Transaction::findOrFail($id);

        // UPDATE STATUS
        $transaction->status = 'paid';
        $transaction->save();

        // HAPUS CART
        Cart::where('user_id', auth()->id())->delete();

        // KIRIM EMAIL E-TICKET
        Mail::to(auth()->user()->email)->send(new ETicketMail($transaction));

        return redirect()->route('user.tickets')->with('success', 'Pembayaran berhasil & e-ticket dikirim!');
    }
}