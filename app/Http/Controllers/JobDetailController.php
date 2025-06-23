<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job; // Pastikan model ini sudah dibuat

class JobDetailController extends Controller
{
public function show($slug)
{
    $job = Job::where('slug', $slug)->firstOrFail();
    return view('home.job-detail', compact('job'));
}
}