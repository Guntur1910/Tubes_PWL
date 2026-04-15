<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TicketType;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // =========================
    // PAYMENT SUCCESS (MANUAL / CALLBACK)
    // =========================
    public function markAsPaid($id)
    {
        $transaction = Transaction::findOrFail($id);

        // ❌ kalau sudah paid, stop
        if ($transaction->status === 'paid') {
            return redirect()->back()->with('info', 'Transaksi sudah dibayar');
        }

        try {
            DB::transaction(function () use ($transaction) {

                $ticketType = TicketType::findOrFail($transaction->ticket_type_id);

                // hitung sisa stok
                $available = $ticketType->quota - $ticketType->sold;

                // ❌ kalau stok gak cukup
                if ($available < $transaction->quantity) {
                    throw new \Exception('Stok tiket tidak cukup');
                }

                // ✅ kurangi stok (tambah sold)
                $ticketType->sold += $transaction->quantity;
                $ticketType->save();

                // ✅ update status transaksi
                $transaction->status = 'paid';
                $transaction->save();
            });

            return redirect()->back()->with('success', 'Pembayaran berhasil & stok terupdate');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}