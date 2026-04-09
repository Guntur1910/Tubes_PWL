@extends('layouts.organizer')

@section('content')
<div class="container py-4">

    <h2 class="mb-4">Dashboard Organizer</h2>

    <div class="row">

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Event</h6>
                    <h3>{{ $totalEvent }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Ticket Terjual</h6>
                    <h3>{{ $totalTicket }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Total Revenue</h6>
                    <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection