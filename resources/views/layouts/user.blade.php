<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', config('app.name'))</title>

    <link rel="icon" href="{{ asset('essence/img/core-img/favicon.ico') }}">

    {{-- CSS Template Essence --}}
    <link rel="stylesheet" href="{{ asset('essence/css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('essence/style.css') }}">

    @stack('styles')
</head>

<body>

    {{-- ===== HEADER ===== --}}
    @include('layouts.partials.essence-header')

    {{-- ===== CART SIDEBAR ===== --}}
    @include('layouts.partials.essence-cart')

    {{-- ===== KONTEN HALAMAN ===== --}}
    @yield('content')

    {{-- ===== FOOTER ===== --}}
    @include('layouts.partials.essence-footer')

    {{-- ===== SCRIPTS ===== --}}
    <script src="{{ asset('essence/js/jquery/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('essence/js/popper.min.js') }}"></script>
    <script src="{{ asset('essence/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('essence/js/plugins.js') }}"></script>
    <script src="{{ asset('essence/js/classy-nav.min.js') }}"></script>
    <script src="{{ asset('essence/js/active.js') }}"></script>

    @stack('scripts')
</body>

</html>
