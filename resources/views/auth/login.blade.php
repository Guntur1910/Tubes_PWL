<form method="POST" action="/login">
    @csrf
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
    @error('email') <span>{{ $message }}</span> @enderror

    <input type="password" name="password" placeholder="Password">
    @error('password') <span>{{ $message }}</span> @enderror

    <button type="submit">Login</button>
    <a href="/register">Belum punya akun?</a>
</form>