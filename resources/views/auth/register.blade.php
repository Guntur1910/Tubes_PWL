<form method="POST" action="/register">
    @csrf
    <input type="text"     name="name"              placeholder="Nama Lengkap">
    <input type="email"    name="email"             placeholder="Email">
    <input type="password" name="password"          placeholder="Password">
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password">

    <select name="role">
        <option value="user">User</option>
        <option value="organizer">Organizer</option>
    </select>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
    @endif

    <button type="submit">Register</button>
    <a href="/login">Sudah punya akun?</a>
</form>