<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProfileCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // Mengecek apakah pengguna sudah login
        if (auth()->check()) {
            // Jika profil belum lengkap, arahkan ke halaman melengkapi profil
            if (is_null(auth()->user()->applicant_profile)) {
                return redirect()->route('profile.complete');
            }
            
            // Jika profil sudah lengkap, mencegah mereka mengakses halaman melengkapi profil
            if (!is_null(auth()->user()->applicant_profile) && $request->is('profile/complete')) {
                return redirect()->route('dashboard'); // Ganti 'dashboard' dengan rute yang sesuai
            }
        }

        return $next($request);
    }
}
