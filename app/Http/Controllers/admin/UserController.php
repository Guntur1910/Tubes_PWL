<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function home()
    {
        return view('user.home');
    }

    public function shop()
    {
        return view('user.shop');
    }

    public function show($id)
    {
    $event = Event::findOrFail($id);

    return view('user.product-detail', compact('event'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,organizer,user',
        ]);
 
        $user->update(['role' => $request->role]);
 
        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$request->role}.");
    }

}