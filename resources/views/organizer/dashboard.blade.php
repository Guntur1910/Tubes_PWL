@extends('layouts.organizer')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Reporting & Analytics</h2>
        <div>
            <button onclick="window.print()" class="btn btn-outline-danger shadow-sm">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-white-50">Total Revenue</h6>
                            <h3 class="fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        </div>
                        <i class="fas fa-wallet fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-white-50">Tiket Terjual</h6>
                            <h3 class="fw-bold">{{ number_format($totalTicket) }}</h3>
                        </div>
                        <i class="fas fa-ticket-alt fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-white-50">Active Events</h6>
                            <h3 class="fw-bold">{{ $totalEvents }}</h3>
                        </div>
                        <i class="fas fa-calendar-check fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Grafik Pendapatan (7 Hari Terakhir)</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            Avg. Tickets per Event
                            <span class="badge bg-primary rounded-pill">{{ $totalEvents > 0 ? round($totalTicket / $totalEvents) : 0 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            Avg. Revenue per Event
                            <span class="badge bg-success rounded-pill">Rp {{ number_format($totalEvents > 0 ? $totalRevenue / $totalEvents : 0) }}</span>
                        </li>
                    </ul>
                    <div class="mt-4 p-3 bg-light rounded text-center">
                        <small class="text-muted">Laporan ini dibuat otomatis berdasarkan transaksi yang sudah lunas (Paid).</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Event Performance Analytics</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Event</th>
                            <th>Tanggal</th>
                            <th class="text-center">Tiket Terjual</th>
                            <th class="text-end">Total Pendapatan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td class="fw-bold">{{ $event->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $event->tickets_sold ?? 0 }}</span>
                                </td>
                                <td class="text-end fw-bold text-success">
                                    Rp {{ number_format($event->revenue ?? 0, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if(\Carbon\Carbon::parse($event->date)->isPast())
                                        <span class="badge bg-light text-dark border">Finished</span>
                                    @else
                                        <span class="badge bg-success shadow-sm">Upcoming</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Belum ada data event untuk dilaporkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->pluck('date')) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartData->pluck('total')) !!},
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endsection