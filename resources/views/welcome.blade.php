<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ticketing</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-600 to-blue-500">

<div class="w-full max-w-md text-center text-white">

    <!-- HEADLINE -->
    <h1 class="text-2xl font-semibold mb-2">
        Temukan Event Terbaik
    </h1>

    <p class="text-sm text-white/80 mb-8">
        Beli tiket dengan cepat, aman, dan tanpa ribet.
    </p>

    <!-- LOGIN CARD -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-6 shadow-xl translate-y-[-12px]">

        <h2 class="text-sm text-white/70 mb-4">
            Masuk ke akun Anda
        </h2>

        <!-- FORM LOGIN -->
        <form method="POST" action="{{ route('login') }}" class="space-y-3">
            @csrf

            <input type="email" name="email" placeholder="Email"
                class="w-full px-4 py-2.5 rounded-lg bg-white/10 border border-white/20 placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/40">

            <input type="password" name="password" placeholder="Password"
                class="w-full px-4 py-2.5 rounded-lg bg-white/10 border border-white/20 placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/40">

            <button type="submit"
                class="w-full bg-white text-indigo-600 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-100 transition">
                Login
            </button>

        </form>

        <!-- LINK REGISTER (FIXED) -->
        <p class="text-xs text-white/70 mt-4">
            Belum punya akun?
            <a href="{{ route('register') }}" class="underline hover:text-white">
                Daftar
            </a>
        </p>

    </div>

</div>

</body>
</html>