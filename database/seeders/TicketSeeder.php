<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Models\Transaction;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua transaksi yang sudah paid tapi belum punya tickets
        $paidTransactions = Transaction::where('status', 'paid')
            ->whereDoesntHave('tickets')
            ->get();

        foreach ($paidTransactions as $transaction) {
            // Generate tickets berdasarkan quantity
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
        }

        $this->command->info('Tickets generated for ' . $paidTransactions->count() . ' transactions');
    }
}
