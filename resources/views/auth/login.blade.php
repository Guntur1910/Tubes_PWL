<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-600 to-blue-500">

<div class="w-full max-w-md text-center text-white">

    <!-- TITLE -->
    <h1 class="text-2xl font-semibold mb-2">
        Masuk ke Akun
    </h1>

    <p class="text-sm text-white/80 mb-8">
        Masuk untuk melanjutkan pembelian tiket.
    </p>

    <!-- CARD -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-6 shadow-xl -mt-6">

        <form method="POST" action="/login" class="space-y-3">
            @csrf

            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                class="w-full px-4 py-2.5 rounded-lg bg-white/10 border border-white/20 placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/40">

            <input type="password" name="password" placeholder="Password"
                class="w-full px-4 py-2.5 rounded-lg bg-white/10 border border-white/20 placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/40">

            @if($errors->any())
                <div class="bg-red-500/20 border border-red-400 text-red-200 p-3 rounded-lg text-sm text-left">
                    @foreach($errors->all() as $error)
                        <p>- {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <button type="submit"
                class="w-full bg-white text-indigo-600 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-100 transition">
                Masuk
            </button>
        </form>

        <p class="text-sm text-white/80 mt-4">
            Belum punya akun? <a href="/register" class="text-white underline hover:text-white/90">Daftar di sini</a>
        </p>

    </div>

</div>

</body>
</html>