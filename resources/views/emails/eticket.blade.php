<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - GIGS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .content {
            padding: 30px 20px;
        }
        
        .greeting {
            margin-bottom: 20px;
        }
        
        .greeting h2 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .ticket-info {
            background-color: #f9f9f9;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .ticket-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .ticket-info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .ticket-info-label {
            font-weight: 600;
            color: #666;
            font-size: 14px;
        }
        
        .ticket-info-value {
            color: #333;
            font-size: 14px;
        }
        
        .qr-section {
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            margin: 20px 0;
        }
        
        .qr-code {
            max-width: 200px;
            height: auto;
            margin: 0 auto;
        }
        
        .qr-section p {
            font-size: 12px;
            color: #666;
            margin-top: 10px;
        }
        
        .transaction-id {
            text-align: center;
            padding: 15px;
            background-color: #f0f0f0;
            border-radius: 4px;
            margin: 15px 0;
            font-size: 12px;
            color: #666;
        }
        
        .transaction-id strong {
            display: block;
            font-size: 16px;
            color: #333;
            margin-top: 5px;
            font-family: 'Courier New', monospace;
        }
        
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
        }
        
        .footer p {
            margin-bottom: 8px;
        }
        
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        
        .highlight {
            background-color: #fff3cd;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            border-left: 4px solid #ffc107;
        }
        
        .highlight strong {
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🎟️ E-TICKET</h1>
            <p>Terima kasih telah membeli tiket melalui GIGS!</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <!-- Greeting -->
            <div class="greeting">
                <h2>Halo, {{ $transaction->user->name ?? 'Pembeli' }}!</h2>
                <p>Tiket Anda telah berhasil dipesan. Simpan email ini dan gunakan untuk check-in di acara.</p>
            </div>
            
            <!-- Ticket Information -->
            <div class="ticket-info">
                <div class="ticket-info-row">
                    <span class="ticket-info-label">Nama Event:</span>
                    <span class="ticket-info-value"><strong>{{ $transaction->event->name ?? 'Event' }}</strong></span>
                </div>
                
                <div class="ticket-info-row">
                    <span class="ticket-info-label">Jenis Tiket:</span>
                    <span class="ticket-info-value">{{ $transaction->ticketType->name ?? '-' }}</span>
                </div>
                
                <div class="ticket-info-row">
                    <span class="ticket-info-label">Jumlah Tiket:</span>
                    <span class="ticket-info-value">{{ $transaction->quantity }} Tiket</span>
                </div>
                
                <div class="ticket-info-row">
                    <span class="ticket-info-label">Total Harga:</span>
                    <span class="ticket-info-value"><strong>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong></span>
                </div>
                
                <div class="ticket-info-row">
                    <span class="ticket-info-label">Status Pembayaran:</span>
                    <span class="ticket-info-value" style="color: #28a745; font-weight: 600;">✓ Lunas</span>
                </div>
            </div>
            
            <!-- QR Code Section -->
            <div class="qr-section">
                <p style="margin-bottom: 10px; font-weight: 600;">Kode QR untuk Check-in</p>
                <img src="cid:qrcode" alt="QR Code" class="qr-code" width="200" height="200">
                <p>Tampilkan QR Code ini saat check-in</p>
            </div>
            
            <!-- Transaction ID -->
            <div class="transaction-id">
                <div>Nomor Transaksi</div>
                <strong>#{{ $transaction->id }}</strong>
            </div>
            
            <!-- Important Notice -->
            <div class="highlight">
                <strong>⚠️ Penting:</strong>
                <p style="margin-top: 8px; margin-bottom: 0;">
                    Jangan bagikan email ini ke orang lain. Tiket ini terikat pada email Anda dan hanya bisa digunakan oleh pemilik akun yang membeli.
                </p>
            </div>
            
            <p style="margin-top: 20px; color: #666; font-size: 14px;">
                Jika Anda memiliki pertanyaan, silakan hubungi tim support kami melalui website atau email.
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>GIGS - Event Ticketing Platform</strong></p>
            <p>Terima kasih telah menjadi bagian dari komunitas kami!</p>
            <p style="margin-top: 15px; color: #999;">
                © {{ date('Y') }} GIGS. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
