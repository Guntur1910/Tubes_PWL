<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    @stack('styles')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
        data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

        {{-- ===== SIDEBAR ===== --}}
        @include('layouts.partials.sidebar')

        <!--  Main wrapper -->
        <div class="body-wrapper">

            {{-- ===== HEADER / TOPBAR ===== --}}
            @include('layouts.partials.topbar')

            {{-- ===== KONTEN HALAMAN ===== --}}
            <div class="body-wrapper-inner">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            {{-- ===== FOOTER ===== --}}
            @include('layouts.partials.footer')

        </div>
    </div>

    {{-- ===== SCRIPTS ===== --}}
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    @stack('scripts')
</body>

</html>
