<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

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

}