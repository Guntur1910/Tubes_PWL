@extends('layouts.user')

@section('content')
<div class="container py-5">
    {{-- HERO SECTION --}}
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
        <img src="{{ asset('essence/img/bg-img/konser1.jpg') }}" style="height:300px; object-fit:cover;">
        <div class="p-4">
            <h2 class="fw-bold">{{ $event->name }}</h2>
            <div class="d-flex gap-3 text-muted">
                <span>📍 {{ $event->location }}</span>
                <span>📅 {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    <form action="{{ route('user.checkout.process') }}" method="POST" id="orderForm">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">
        
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm rounded-3 p-5 border-0">
                    <h4 class="fw-bold mb-4">🎟️ Pilih Jenis Tiket</h4>

                    @php
                        $ticketTypes = $event->ticketTypes;
                    @endphp

                    @if($ticketTypes->count() > 0)
                        <div class="row g-3" id="ticketOptions">
                            @foreach($ticketTypes as $type)
                            <div class="col-md-6">
                                <label class="ticket-card p-4 rounded-3 border-2 cursor-pointer transition {{ $type->quota - $type->sold <= 0 ? 'opacity-50' : '' }}" style="cursor: {{ $type->quota - $type->sold <= 0 ? 'not-allowed' : 'pointer' }}; border: 2px solid #e0e0e0;">
                                    <input type="radio" name="ticket_type_id" value="{{ $type->id }}" class="ticket-radio" data-price="{{ $type->price }}" data-name="{{ $type->name }}" {{ $type->quota - $type->sold <= 0 ? 'disabled' : '' }} style="display: none;">
                                    
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="fw-bold mb-0">{{ $type->name }}</h5>
                                        <span class="badge bg-primary">Rp {{ number_format($type->price, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    @if($type->description)
                                    <p class="text-muted small mb-2">{{ $type->description }}</p>
                                    @endif

                                    <div class="d-flex justify-content-between small text-muted">
                                        <span>📦 Stok: {{ $type->quota - $type->sold }} / {{ $type->quota }}</span>
                                        @if($type->quota - $type->sold <= 0)
                                            <span id="stock-status-{{ $type->id }}" class="text-danger">✗ Habis</span>
                                        @else
                                            <span id="stock-status-{{ $type->id }}" class="text-success">✓ Tersedia</span>
                                        @endif
                                    </div>

                                    @if($type->quota - $type->sold <= 0)
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-warning btn-sm w-100" onclick="joinWaitingList({{ $type->id }}, '{{ $type->name }}')">
                                                🔔 Join Waiting List
                                            </button>
                                        </div>
                                    @endif
                                </label>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning">
                            ⚠️ Belum ada jenis tiket yang tersedia untuk event ini.
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-lg rounded-3 p-4 border-0 position-sticky" style="top: 20px;">
                    <h5 class="fw-bold mb-4">📋 Ringkasan Pesanan</h5>
                    
                    <div class="mb-3 pb-3 border-bottom">
                        <p class="text-muted mb-1"><small>Event</small></p>
                        <p class="fw-bold">{{ $event->name }}</p>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <p class="text-muted mb-1"><small>Jenis Tiket</small></p>
                        <p class="fw-bold" id="selectedTicketName">-</p>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <label for="quantityInput" class="form-label"><small class="text-muted">Jumlah Tiket</small></label>
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-secondary px-3" id="decreaseQty" style="flex: 0 0 auto;">−</button>
                            <input type="number" class="form-control text-center" id="quantityInput" name="quantity" min="1" value="1" readonly>
                            <button type="button" class="btn btn-outline-secondary px-3" id="increaseQty" style="flex: 0 0 auto;">+</button>
                        </div>
                    </div>

                    <div class="mb-4 pb-3 border-bottom">
                        <p class="text-muted mb-2"><small>Harga Satuan</small></p>
                        <p class="fw-bold text-primary" id="unitPrice">Rp 0</p>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="text-muted mb-0">Total</h6>
                            <h4 class="text-primary fw-bold mb-0">Rp <span id="totalDisplay">0</span></h4>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-3 shadow-sm" id="btnSubmit" disabled>
                        🛒 Tambah ke Keranjang
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .ticket-card {
        transition: all 0.3s ease;
        background-color: #ffffff;
    }

    .ticket-card:hover {
        border-color: #007bff !important;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
        transform: translateY(-2px);
    }

    .ticket-card input:checked + * {
        color: #007bff;
    }

    input[type="radio"]:checked + * {
        color: #007bff;
    }

    label.ticket-card input[type="radio"]:checked ~ * {
        border-color: #007bff !important;
    }

    .ticket-card input[type="radio"]:checked ~ div {
        border-color: #007bff;
    }

    input[type="radio"]:checked + div {
        border-color: #007bff !important;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ticketRadios = document.querySelectorAll('input[name="ticket_type_id"]');
    const quantityInput = document.getElementById('quantityInput');
    const selectedTicketName = document.getElementById('selectedTicketName');
    const unitPrice = document.getElementById('unitPrice');
    const totalDisplay = document.getElementById('totalDisplay');
    const btnSubmit = document.getElementById('btnSubmit');
    const decreaseBtn = document.getElementById('decreaseQty');
    const increaseBtn = document.getElementById('increaseQty');

    let selectedPrice = 0;
    let selectedTicketType = null;

    function formatRupiah(value) {
        return value.toLocaleString('id-ID');
    }

    function updateCardStyle() {
        document.querySelectorAll('.ticket-card').forEach(card => {
            card.style.borderColor = '#e0e0e0';
            card.style.backgroundColor = '#ffffff';
        });

        ticketRadios.forEach(radio => {
            if (radio.checked) {
                const card = radio.closest('label.ticket-card');
                if (card) {
                    card.style.borderColor = '#007bff';
                    card.style.backgroundColor = '#f0f7ff';
                }
            }
        });
    }

    function updateTotal() {
        let quantity = parseInt(quantityInput.value, 10);
        if (isNaN(quantity) || quantity < 1) {
            quantity = 1;
            quantityInput.value = quantity;
        }

        const total = quantity * selectedPrice;
        totalDisplay.textContent = formatRupiah(total);
        unitPrice.textContent = 'Rp ' + formatRupiah(selectedPrice);
    }

    ticketRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                selectedPrice = parseInt(this.dataset.price, 10);
                selectedTicketType = this.dataset.name;
                selectedTicketName.textContent = selectedTicketType;
                updateTotal();
                updateCardStyle();
                btnSubmit.disabled = false;
            }
        });
    });

    decreaseBtn.addEventListener('click', function() {
        const current = parseInt(quantityInput.value, 10) || 1;
        if (current > 1) {
            quantityInput.value = current - 1;
            updateTotal();
        }
    });

    increaseBtn.addEventListener('click', function() {
        const current = parseInt(quantityInput.value, 10) || 1;
        quantityInput.value = current + 1;
        updateTotal();
    });

    quantityInput.addEventListener('input', function() {
        let quantity = parseInt(this.value, 10);
        if (isNaN(quantity) || quantity < 1) {
            quantity = 1;
        }
        this.value = quantity;
        updateTotal();
    });
});

// Function untuk join waiting list
function joinWaitingList(ticketTypeId, ticketName) {
    if (confirm(`Apakah Anda ingin bergabung waiting list untuk tiket "${ticketName}"?\n\nAnda akan diberitahu via email jika tiket tersedia kembali.`)) {
        fetch('{{ route("user.tickets.join-waiting-list") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                ticket_type_id: ticketTypeId,
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Terjadi kesalahan. Silakan coba lagi.');
        });
    }
}
</script>
@endsection