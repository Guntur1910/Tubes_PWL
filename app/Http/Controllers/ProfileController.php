<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile');
    }

    public function edit()
    {
        return view('user.edit-profile');
    }

    public function update(Request $request)
    {
        // ✅ VALIDASI (FIX PASSWORD)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|min:6', // ❌ hapus confirmed biar gak ngeblok
        ]);

        $user = Auth::user();

        // ✅ UPDATE DATA
        $user->name = $request->name;
        $user->email = $request->email;

        // 🔥 HANDLE CROPPED IMAGE
        if ($request->photo_cropped) {

            $image = $request->photo_cropped;

            // hapus prefix base64
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);

            $imageName = time() . '.png';

            // simpan ke storage/public/profile
            Storage::disk('public')->put('profile/' . $imageName, base64_decode($image));

            // simpan ke database
            $user->photo = $imageName;
        }

        // 🔐 UPDATE PASSWORD (kalau diisi aja)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile berhasil diupdate!');
    }
}