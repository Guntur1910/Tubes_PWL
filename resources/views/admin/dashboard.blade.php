@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- ===== ROW 1: Chart + Stats ===== --}}
<div class="row">

    {{-- Sales Overview Chart --}}
    <div class="col-lg-8">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Sales Overview</h4>
                        <p class="card-subtitle">Statistik penjualan</p>
                    </div>
                    <div class="ms-auto">
                        <ul class="list-unstyled mb-0">
                            <li class="list-inline-item text-primary">
                                <span class="round-8 text-bg-primary rounded-circle me-1 d-inline-block"></span>
                                Produk A
                            </li>
                            <li class="list-inline-item text-info">
                                <span class="round-8 text-bg-info rounded-circle me-1 d-inline-block"></span>
                                Produk B
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="sales-overview" class="mt-4 mx-n6"></div>
            </div>
        </div>
    </div>

    {{-- Weekly Stats --}}
    <div class="col-lg-4">
        <div class="card overflow-hidden">
            <div class="card-body pb-0">
                <h4 class="card-title">Weekly Stats</h4>
                <p class="card-subtitle">Rata-rata penjualan</p>

                <div class="mt-4 pb-3 d-flex align-items-center">
                    <span class="btn btn-primary rounded-circle round-48 hstack justify-content-center">
                        <i class="ti ti-shopping-cart fs-6"></i>
                    </span>
                    <div class="ms-3">
                        <h5 class="mb-0 fw-bolder fs-4">Top Sales</h5>
                        <span class="text-muted fs-3">{{ $topSales ?? 'Belum ada data' }}</span>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-secondary-subtle text-muted">+68%</span>
                    </div>
                </div>

                <div class="py-3 d-flex align-items-center">
                    <span class="btn btn-warning rounded-circle round-48 hstack justify-content-center">
                        <i class="ti ti-star fs-6"></i>
                    </span>
                    <div class="ms-3">
                        <h5 class="mb-0 fw-bolder fs-4">Best Seller</h5>
                        <span class="text-muted fs-3">{{ $bestSeller ?? 'Belum ada data' }}</span>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-secondary-subtle text-muted">+45%</span>
                    </div>
                </div>

                <div class="py-3 d-flex align-items-center">
                    <span class="btn btn-success rounded-circle round-48 hstack justify-content-center">
                        <i class="ti ti-message-dots fs-6"></i>
                    </span>
                    <div class="ms-3">
                        <h5 class="mb-0 fw-bolder fs-4">Most Commented</h5>
                        <span class="text-muted fs-3">{{ $mostCommented ?? 'Belum ada data' }}</span>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-secondary-subtle text-muted">+30%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Tabel Products Performance ===== --}}
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">Products Performance</h4>
                        <p class="card-subtitle">Data performa produk</p>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                        <thead>
                            <tr>
                                <th class="px-0 text-muted">Assigned</th>
                                <th class="px-0 text-muted">Name</th>
                                <th class="px-0 text-muted">Priority</th>
                                <th class="px-0 text-muted text-end">Budget</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Jika ada data dari controller --}}
                            @forelse($products ?? [] as $product)
                            <tr>
                                <td class="px-0">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('assets/images/profile/user-3.jpg') }}"
                                            class="rounded-circle" width="40" alt="user" />
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bolder">{{ $product->user->name }}</h6>
                                            <span class="text-muted">{{ $product->user->role }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-0">{{ $product->name }}</td>
                                <td class="px-0">
                                    <span class="badge bg-{{ $product->priority_color }}">
                                        {{ $product->priority }}
                                    </span>
                                </td>
                                <td class="px-0 text-dark fw-medium text-end">{{ $product->budget }}</td>
                            </tr>
                            @empty
                            {{-- Data dummy jika belum ada data dari database --}}
                            <tr>
                                <td class="px-0">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('assets/images/profile/user-3.jpg') }}"
                                            class="rounded-circle" width="40" alt="user" />
                                        <div class="ms-3">
                                            <h6 class="mb-0 fw-bolder">Sunil Joshi</h6>
                                            <span class="text-muted">Web Designer</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-0">Elite Admin</td>
                                <td class="px-0"><span class="badge bg-info">Low</span></td>
                                <td class="px-0 text-dark fw-medium text-end">$3.9K</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    // Contoh chart ApexCharts - sesuaikan dengan data dari controller
    var options = {
        series: [{
            name: 'Produk A',
            data: [31, 40, 28, 51, 42, 109, 100]
        }, {
            name: 'Produk B',
            data: [11, 32, 45, 32, 34, 52, 41]
        }],
        chart: { type: 'area', height: 350, toolbar: { show: false } },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']
        },
        colors: ['#1e4db7', '#0bb2fb'],
        stroke: { curve: 'smooth' },
        fill: { type: 'gradient' }
    };

    var chart = new ApexCharts(document.querySelector("#sales-overview"), options);
    chart.render();
</script>
@endpush
