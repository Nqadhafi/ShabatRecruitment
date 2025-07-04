<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamTitle;
use App\Models\Application;
use App\Models\ExamResult;

class ExamController extends Controller
{
    //
    public function examPreparation()
    {
        // Logic for exam preparation

        $applicantId = auth()->user()->applicantProfile->id;
        $hasApplied = Application::where('applicant_profile_id', $applicantId)->exists();

        if (!$hasApplied) {
            return redirect()->route('applicant.dashboard')->with('error', 'Anda belum melamar ke lowongan apa pun.');
        }


        // Ambil semua judul ujian aktif
        $examTitles = ExamTitle::where('is_active', true)
            ->withCount('questions')
            ->get();
        return view('applicant.exam-preparation',  compact('examTitles'));
    }
}
