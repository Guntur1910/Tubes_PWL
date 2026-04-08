<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Essence (punya kamu) -->
    <link rel="stylesheet" href="{{ asset('essence/css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('essence/style.css') }}">
</head>
<body>

    {{-- HEADER --}}
    @include('layouts.partials.essence-header') 

    {{-- CONTENT --}}
    @yield('content')


    @include('layouts.partials.essence-footer')

    <!-- JS -->
    <script src="{{ asset('essence/js/jquery/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('essence/js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('essence/js/bootstrap/bootstrap.min.js') }}"></script>
</body>
</html>