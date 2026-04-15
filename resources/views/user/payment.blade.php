@extends('layouts.user')

@section('content')
<div class="container text-center" style="padding: 80px 0;">

    <h2>Scan QRIS</h2>

    <img src="{{ asset('qrcodes/qr_' . $transaction->id . '.png') }}" width="250">

    <h4 class="mt-3">
        Total: Rp {{ number_format($transaction->total_amount,0,',','.') }}
    </h4>

    <form action="{{ route('user.payment.success', $transaction->id) }}" method="POST">
        @csrf
        <button class="btn btn-success mt-3">
            Saya Sudah Bayar
        </button>
    </form>

</div>
@endsection