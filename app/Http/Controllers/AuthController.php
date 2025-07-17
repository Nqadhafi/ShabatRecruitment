<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Fungsi untuk menampilkan form login
    public function showLoginForm()
    {
        if (Auth::check()) {
            // Jika pengguna sudah login, alihkan ke dashboard yang sesuai
            return redirect()->route(Auth::user()->role . '.dashboard'); // admin.dashboard atau applicant.dashboard
        }

        return view('auth.login');
    }

    // Fungsi untuk login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha', // Validasi captcha
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;
            $dashboardRoute = $role === 'admin' ? 'admin.dashboard' : 'applicant.dashboard';
            return redirect()->route($dashboardRoute); // Redirect berdasarkan role
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Fungsi untuk menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Fungsi untuk logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
