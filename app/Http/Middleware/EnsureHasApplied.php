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
               $jobId = session('applied_job_id'); // Atau ambil dari cara lain

        if (!$jobId || !Application::where('job_id', $jobId)
                                    ->where('user_id', Auth::id())
                                    ->exists()) {
            return redirect()
                ->route('applicant.jobs-panel')
                ->with('error', 'Anda harus melamar terlebih dahulu untuk mengikuti ujian.');
        }
        return $next($request);
    }
}
