@extends('layouts.user')

@section('content')

<div class="container py-5">

    {{-- HERO --}}
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
        <img src="{{ asset('essence/img/bg-img/konser1.jpg') }}" style="height:300px; object-fit:cover;">

        <div class="p-4">
            <h2 class="fw-bold">{{ $event->name }}</h2>
            <p class="text-muted mb-1">📍 {{ $event->location }}</p>
            <p class="text-muted">📅 {{ $event->date }}</p>
        </div>
    </div>

    <div class="row">

        {{-- SEAT --}}
        <div class="col-lg-8">
            <div class="card shadow rounded-4 p-4">

                <h4 class="mb-3 fw-bold">Pilih Kursi 💺</h4>

                <div class="text-center">
                    @for ($row = 1; $row <= 5; $row++)
                        <div class="d-flex justify-content-center">
                            @for ($col = 1; $col <= 10; $col++)
                                <div class="seat"
                                     data-seat="R{{ $row }}-{{ $col }}"
                                     data-price="{{ $event->price }}">
                                </div>
                            @endfor
                        </div>
                    @endfor
                </div>

            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="col-lg-4">
            <div class="card shadow rounded-4 p-4">

                <h5 class="fw-bold">Ringkasan</h5>

                <p><strong>Event:</strong> {{ $event->name }}</p>

                <ul id="selectedSeats"></ul>

                <hr>

                <h5>Total: Rp <span id="totalPrice">0</span></h5>

                <button class="btn btn-primary w-100 rounded-pill">
                    Beli Tiket 🎫
                </button>

            </div>
        </div>

    </div>

</div>

@endsection

@section('scripts')

<style>
.seat {
    width: 30px;
    height: 30px;
    background: #ddd;
    margin: 4px;
    border-radius: 6px;
    cursor: pointer;
}
.seat.selected {
    background: #28a745;
}
</style>

<script>
let selectedSeats = [];
let total = 0;

document.querySelectorAll('.seat').forEach(seat => {
    seat.addEventListener('click', function () {

        const id = this.dataset.seat;
        const price = parseInt(this.dataset.price);

        if (this.classList.contains('selected')) {
            this.classList.remove('selected');
            selectedSeats = selectedSeats.filter(s => s !== id);
            total -= price;
        } else {
            this.classList.add('selected');
            selectedSeats.push(id);
            total += price;
        }

        document.getElementById('selectedSeats').innerHTML =
            selectedSeats.map(s => `<li>${s}</li>`).join('');

        document.getElementById('totalPrice').innerText =
            total.toLocaleString();
    });
});
</script>

@endsection