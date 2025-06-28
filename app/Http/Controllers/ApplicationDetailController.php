<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationDetailController extends Controller
{
    //
    public function history()
    {
        $applicantProfileId = Auth::user()->applicantProfile->id;
        if (!$applicantProfileId) {
            return redirect()->route('applicant.dashboard')->with('error', 'Profil pelamar tidak ditemukan.');
        }

        $applications = Application::where('applicant_profile_id', $applicantProfileId)
            ->with('job')
            ->orderByDesc('created_at')
            ->get();

        return view('applicant.applications', compact('applications'));
    }

    public function applicationDetail($applicationId)
    {
        $application = Application::where('id', $applicationId)
            ->where('applicant_profile_id', Auth::user()->applicantProfile->id)
            ->with('job')
            ->firstOrFail();

        return view('applicant.applications-detail', compact('application'));
    }
}
