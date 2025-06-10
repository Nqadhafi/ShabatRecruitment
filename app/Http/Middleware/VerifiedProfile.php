<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifiedProfile
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

         if (auth()->check()) {
            // Jika profil belum lengkap, arahkan ke halaman melengkapi profil
            if (!is_null(auth()->user()->profiles_uuid)) {
                return redirect()->route('applicant.dashboard');
            }
        }
        return $next($request);
    }
}
