<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureHasApplied
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
               $hasApplied = session('application_id'); // Atau ambil dari cara lain

        if (!$hasApplied){
                                  
            return redirect()
                ->route('applicant.jobs-panel')
                ->with('error', 'Anda harus melamar terlebih dahulu untuk mengikuti ujian.');
        }
        return $next($request);
    }
}
