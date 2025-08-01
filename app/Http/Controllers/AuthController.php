<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->peran === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('karyawan.dashboard');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_telp' => 'required',
            'divisi' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'divisi' => $request->divisi,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'peran' => 'karyawan',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
