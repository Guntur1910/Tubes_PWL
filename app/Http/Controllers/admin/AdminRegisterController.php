<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminRegisterController extends Controller
{
    public function showForm()
    {
        if (User::where('role', 'admin')->exists()) {
            abort(403, 'Admin sudah terdaftar.');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        if (User::where('role', 'admin')->exists()) {
            abort(403, 'Admin sudah terdaftar.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $admin = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        Auth::login($admin);

        return redirect('/admin/dashboard')->with('success', 'Akun admin berhasil dibuat!');
    }
}