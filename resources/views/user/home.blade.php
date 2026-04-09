@extends('layouts.user')

@section('title', 'Home - ' . config('app.name'))

@section('content')

@php
    $heroEvent = $popularProducts->first();
@endphp

<!-- ================= HERO SECTION ================= -->
<section class="welcome_area position-relative" style="height: 500px;">
    <div class="carousel-item active h-100 bg-img background-overlay"
         style="background-image: url('{{ asset('essence/img/bg-img/konser1.jpg') }}');">

        <div class="container h-100 position-relative z-2">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center text-white">

                    @if($heroEvent)
                        <h6 class="text-uppercase mb-3">
                            {{ \Carbon\Carbon::parse($heroEvent->date)->format('d M Y') }}
                        </h6>

                        <h1 class="display-4 fw-bold mb-3">
                            {{ $heroEvent->name }}
                        </h1>

                        <p class="mb-2">📍 {{ $heroEvent->location }}</p>

                        <div id="countdown" class="fw-bold fs-5 mb-3"></div>

                        <a href="{{ route('user.event', $heroEvent->id) }}"
                           class="btn essence-btn btn-lg rounded-pill px-5">
                            🎫 Beli Tiket Sekarang
                        </a>
                    @else
                        <h2>Event Terbaru Akan Segera Hadir</h2>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>


<!-- ================= SEARCH ================= -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="col-md-6 mx-auto">
            <input type="text" id="searchEvent"
                   class="form-control rounded-pill shadow-sm"
                   placeholder="Cari event...">
        </div>
    </div>
</section>


<!-- ================= EVENT LIST ================= -->
<section class="section-padding-100">
    <div class="container">

        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="fw-bold">🔥 Event Populer</h2>
                <p class="text-muted">Temukan pengalaman konser terbaikmu 🎶</p>
            </div>
        </div>

        <div class="row" id="eventList">

            @forelse($popularProducts as $event)
            <div class="col-md-4 mb-4 event-card" data-aos="fade-up">
                <div class="card border-0 rounded-4 h-100 shadow-sm">

                    <img src="{{ $event->image ?? asset('essence/img/bg-img/konser2.jpg') }}"
                         class="card-img-top rounded-top-4"
                         style="height:220px; object-fit:cover;">

                    <div class="card-body text-center">

                        @if($event->quota <= 0)
                            <span class="badge bg-danger mb-2">SOLD OUT</span>
                        @elseif($event->quota <= 20)
                            <span class="badge bg-warning text-dark mb-2">🔥 Hampir Habis</span>
                        @endif

                        <h5 class="fw-bold">{{ $event->name }}</h5>

                        <p class="text-muted small mb-1">
                            📅 {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                        </p>

                        <p class="text-muted small">
                            📍 {{ $event->location }}
                        </p>

                        <h5 class="fw-bold text-primary mb-3">
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                        </h5>

                        <!-- Progress Kuota -->
                        @php
                            $percentage = min(100, ($event->quota / 100) * 100);
                        @endphp

                        <div class="progress mb-3" style="height:6px;">
                            <div class="progress-bar bg-success"
                                 style="width: {{ $percentage }}%">
                            </div>
                        </div>

                        <a href="{{ route('user.event', $event->id) }}"
                           class="btn btn-dark w-100 rounded-pill">
                            Lihat Detail
                        </a>

                    </div>
                </div>
            </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada event tersedia.</p>
                </div>
            @endforelse

        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $popularProducts->links() }}
        </div>

    </div>
</section>


<!-- ================= COMING SOON ================= -->
<section class="py-5 bg-dark text-white text-center">
    <div class="container">
        <h3 class="fw-bold">🎶 Coming Soon</h3>
        <p class="text-muted">Event spektakuler lainnya segera hadir!</p>
    </div>
</section>


<!-- ================= BRAND LOGO ================= -->
<div class="brands-area d-flex align-items-center justify-content-between p-4">
    @for($i = 1; $i <= 6; $i++)
        <div class="single-brands-logo">
            <img src="{{ asset('essence/img/core-img/brand' . $i . '.png') }}">
        </div>
    @endfor
</div>


<!-- ================= DARK MODE TOGGLE ================= -->
<div class="text-center py-3">
    <button id="darkModeToggle" class="btn btn-outline-dark rounded-pill">
        🌙 Toggle Dark Mode
    </button>
</div>


<!-- ================= SCRIPT ================= -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init();

// SEARCH FILTER
document.getElementById("searchEvent").addEventListener("keyup", function() {
    let value = this.value.toLowerCase();
    document.querySelectorAll(".event-card").forEach(function(card) {
        card.style.display = card.innerText.toLowerCase().includes(value) ? "" : "none";
    });
});

// COUNTDOWN
@if($heroEvent)
const eventDate = new Date("{{ $heroEvent->date }}").getTime();
const countdown = document.getElementById("countdown");

setInterval(function(){
    const now = new Date().getTime();
    const distance = eventDate - now;

    if(distance > 0){
        const days = Math.floor(distance / (1000*60*60*24));
        const hours = Math.floor((distance % (1000*60*60*24))/(1000*60*60));
        countdown.innerHTML = "⏳ " + days + " Hari " + hours + " Jam Lagi";
    } else {
        countdown.innerHTML = "Event Sedang Berlangsung!";
    }
}, 1000);
@endif

// DARK MODE
document.getElementById("darkModeToggle").addEventListener("click", function(){
    document.body.classList.toggle("dark-mode");
});
</script>


<!-- ================= STYLE ================= -->
<style>
.background-overlay::before{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(to bottom,rgba(0,0,0,0.6),rgba(0,0,0,0.8));
}

.card {
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.dark-mode {
    background-color:#121212;
    color:white;
}
.dark-mode .card {
    background-color:#1f1f1f;
    color:white;
}
</style>

@endsection