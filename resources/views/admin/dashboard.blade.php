@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Dashboard - Event Management System</h1>
    </div>

    <!-- ===================== SUMMARY CARDS ===================== -->
    <div class="row">

        <!-- Total Event -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalEvent }}</h3>
                    <p>Total Events</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar"></i>
                </div>
            </div>
        </div>

        <!-- Total Tickets Sold -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalTicketSold }}</h3>
                    <p>Tickets Sold</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Rp {{ number_format($totalRevenue,0,',','.') }}</h3>
                    <p>Total Revenue</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalUser }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- ===================== CHART ===================== -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Monthly Revenue</h3>
        </div>
        <div class="card-body">
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>

    <!-- ===================== LATEST EVENTS ===================== -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Latest Events</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Quota</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestEvents as $event)
                        <tr>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->date }}</td>
                            <td>{{ $event->location }}</td>
                            <td>{{ $event->quota }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No events available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===================== LATEST TRANSACTIONS ===================== -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Latest Transactions</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestTransactions as $trx)
                        <tr>
                            <td>{{ $trx->invoice_number }}</td>
                            <td>{{ $trx->user->name ?? '-' }}</td>
                            <td>Rp {{ number_format($trx->total_amount,0,',','.') }}</td>
                            <td>
                                @if($trx->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($trx->status == 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-danger">Failed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No transactions available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyLabels ?? []) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($monthlyRevenue ?? []) !!},
                borderWidth: 2,
                fill: false,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endsection