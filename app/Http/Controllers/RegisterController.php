<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'role' => ['required', 'string', 'in:user,admin'], // Validasi Role
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role, // Simpan role ke database
        'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));
    Auth::login($user);

    return redirect(RouteServiceProvider::HOME);
}
}
