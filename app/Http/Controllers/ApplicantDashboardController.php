<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicantDashboardController extends Controller
{
    public function index()
    {
        // Dashboard untuk Pelamar
        return view('applicant.dashboard');
    }
}
