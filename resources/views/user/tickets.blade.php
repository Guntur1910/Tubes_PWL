@extends('layouts.user')

@section('title', 'My Tickets')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">My E-Tickets</h4>
                </div>
                <div class="card-body">
                    @if($transactions->count() > 0)
                        @foreach($transactions as $transaction)
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">{{ $transaction->event->name }}</h5>
                                        <small>{{ $transaction->event->location }} - {{ $transaction->event->date }}</small>
                                    </div>
                                    <div class="text-right">
                                        <span class="badge badge-light">{{ $transaction->ticketType->name }}</span>
                                        @if($transaction->tickets->count() === 0)
                                            <form action="{{ route('user.tickets.generate', $transaction) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fa fa-qrcode"></i> Generate E-Tickets
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($transaction->tickets->count() > 0)
                                    <div class="row">
                                        @foreach($transaction->tickets as $ticket)
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card border {{ $ticket->status === 'used' ? 'border-danger' : 'border-success' }}">
                                                <div class="card-body text-center">
                                                    <h6 class="card-title">{{ $ticket->ticket_code }}</h6>

                                                    @if($ticket->qr_code_path && \Storage::disk('public')->exists($ticket->qr_code_path))
                                                        <img src="{{ asset('storage/' . $ticket->qr_code_path) }}"
                                                             alt="QR Code"
                                                             class="img-fluid mb-2"
                                                             style="max-width: 150px;">
                                                    @endif

                                                    <div class="mb-2">
                                                        @if($ticket->status === 'unused')
                                                            <span class="badge badge-success">✓ Belum Digunakan</span>
                                                        @elseif($ticket->status === 'used')
                                                            <span class="badge badge-danger">✗ Sudah Digunakan</span>
                                                            <br><small class="text-muted">{{ $ticket->used_at ? $ticket->used_at->format('d/m/Y H:i') : '' }}</small>
                                                        @else
                                                            <span class="badge badge-secondary">Dibatalkan</span>
                                                        @endif
                                                    </div>

                                                    <button class="btn btn-sm btn-outline-primary" onclick="downloadQR('{{ $ticket->ticket_code }}')">
                                                        <i class="fa fa-download"></i> Download QR
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fa fa-ticket-alt fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">E-tickets belum di-generate</p>
                                        <form action="{{ route('user.tickets.generate', $transaction) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-qrcode"></i> Generate E-Tickets Sekarang
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fa fa-ticket-alt fa-4x text-muted mb-4"></i>
                            <h4 class="text-muted">Belum ada tiket</h4>
                            <p class="text-muted">Anda belum memiliki tiket apapun. Mulai beli tiket event favorit Anda!</p>
                            <a href="{{ route('user.shop') }}" class="btn btn-primary">
                                <i class="fa fa-shopping-cart"></i> Belanja Tiket
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function downloadQR(ticketCode) {
    // Create temporary link to download QR
    const link = document.createElement('a');
    link.href = `{{ asset('storage/qr-codes/') }}/${ticketCode}.png`;
    link.download = `${ticketCode}.png`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
@endsection