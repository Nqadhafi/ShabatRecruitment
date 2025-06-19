<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureHasNotAppliedYet
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
        $jobId = $request->route('jobId');

        if (Application::where('job_id', $jobId)
                        ->where('applicant_profile_id', auth()->user()->applicantProfile->id)
                        ->exists()) {
            return redirect()
                ->route('applicant.jobs-panel')
                ->with('error', 'Anda sudah pernah melamar untuk lowongan ini.');
        }
        return $next($request);
    }
}
