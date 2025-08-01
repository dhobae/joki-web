<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan form login (ubah nama method sesuai route)
     */
    public function showLoginForm()  // Ganti dari formLogin() ke showLoginForm()
    {
        return view('pages.auth.login');
    }

    /**
     * Proses login
     */
    public function authenticate(Request $request)  // Ganti dari login() ke authenticate()
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
