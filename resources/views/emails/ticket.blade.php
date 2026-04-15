<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket: {{ $transaction->event->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #007bff; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background: #f8f9fa; padding: 20px; border-radius: 0 0 5px 5px; }
        .ticket { background: white; border: 1px solid #dee2e6; margin: 10px 0; padding: 15px; border-radius: 5px; }
        .ticket-code { font-weight: bold; color: #007bff; font-size: 18px; }
        .event-info { margin: 10px 0; }
        .qr-note { background: #fff3cd; border: 1px solid #ffeaa7; padding: 10px; border-radius: 3px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>E-Ticket Event</h1>
            <h2>{{ $transaction->event->name }}</h2>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $transaction->user->name }}</strong>,</p>

            <p>Terima kasih telah membeli tiket untuk event <strong>{{ $transaction->event->name }}</strong>.
            Berikut adalah detail tiket Anda:</p>

            <div class="event-info">
                <p><strong>Event:</strong> {{ $transaction->event->name }}</p>
                <p><strong>Lokasi:</strong> {{ $transaction->event->location }}</p>
                <p><strong>Tanggal:</strong> {{ $transaction->event->date }}</p>
                <p><strong>Kategori Tiket:</strong> {{ $transaction->ticketType->name }}</p>
                <p><strong>Jumlah:</strong> {{ $transaction->quantity }}</p>
                <p><strong>Total Pembayaran:</strong> Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
            </div>

            <div class="qr-note">
                <strong>📱 QR Code Tiket:</strong><br>
                QR Code untuk setiap tiket telah dilampirkan dalam email ini.
                Simpan QR Code dengan baik dan tunjukkan saat masuk ke venue.
            </div>

            @foreach($tickets as $ticket)
            <div class="ticket">
                <div class="ticket-code">Ticket Code: {{ $ticket->ticket_code }}</div>
                <p><strong>Status:</strong>
                    @if($ticket->status === 'unused')
                        <span style="color: #28a745;">✓ Belum Digunakan</span>
                    @elseif($ticket->status === 'used')
                        <span style="color: #dc3545;">✗ Sudah Digunakan</span>
                    @else
                        <span style="color: #6c757d;">Dibatalkan</span>
                    @endif
                </p>
                <p><em>Tunjukkan QR Code yang sesuai dengan kode tiket ini saat scan di venue.</em></p>
            </div>
            @endforeach

            <div style="background: #e9ecef; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <h4>📋 Instruksi Penggunaan Tiket:</h4>
                <ol>
                    <li>Bawa QR Code yang dilampirkan dalam email ini</li>
                    <li>Tunjukkan QR Code kepada petugas di pintu masuk</li>
                    <li>Pastikan kode tiket sesuai dengan yang tertera di atas</li>
                    <li>Tiket hanya bisa digunakan sekali</li>
                    <li>Datanglah tepat waktu sesuai jadwal event</li>
                </ol>
            </div>

            <p>Jika Anda mengalami kesulitan atau memiliki pertanyaan, silakan hubungi customer service kami.</p>

            <p>Selamat menikmati event!</p>

            <div class="footer">
                <p>Email ini dikirim secara otomatis oleh sistem Event Ticket Management</p>
                <p>&copy; 2026 Event Management System. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>