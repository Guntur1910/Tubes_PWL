<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-600 to-blue-500">

<div class="w-full max-w-md text-center text-white">

    <!-- TITLE -->
    <h1 class="text-2xl font-semibold mb-2">
        Buat Akun Baru
    </h1>

    <p class="text-sm text-white/80 mb-8">
        Mulai beli tiket event favoritmu sekarang.
    </p>

    <!-- CARD -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-6 shadow-xl -mt-6">

        <form method="POST" action="/user/register" class="space-y-3">
            @csrf

            <input type="text" name="name" placeholder="Nama Lengkap"
                class="w-full px-4 py-2.5 rounded-lg bg-white/10 border border-white/20 placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/40">

            <input type="email" name="email" placeholder="Email"
                class="w-full px-4 py-2.5 rounded-lg bg-white/10 border border-white/20 placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/40">

            <input type="password" name="password" placeholder="Password"
                class="w-full px-4 py-2.5 rounded-lg bg-white/10 border border-white/20 placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/40">

            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
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
                Register
            </button>

        </form>

        <p class="text-xs text-white/70 mt-4">
            Sudah punya akun?
            <a href="/login" class="underline">
                Login
            </a>
        </p>

    </div>

</div>

</body>
</html>