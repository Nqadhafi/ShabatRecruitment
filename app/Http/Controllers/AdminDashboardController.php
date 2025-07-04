<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Facades\DB;
class AdminDashboardController extends Controller
{
public function index()
    {
        // Statistik
        $pending = Application::where('status', 'pending')->count();
        $hired = Application::where('status', 'hired')->count();
        $rejected = Application::where('status', 'rejected')->count();
        $activeJobs = Job::where('is_active', true)->count();

        // Lamaran terbaru
        $latestApplications = Application::with(['applicantProfile', 'job'])
            ->latest()
            ->take(5)
            ->get();

        // Data grafik lamaran per bulan (contoh 6 bulan terakhir)
    $query = "
        SELECT 
            DATE_FORMAT(created_at, '%Y%m') AS ym,
            DATE_FORMAT(created_at, '%M %Y') AS month,
            COUNT(*) AS total
        FROM applications
        GROUP BY DATE_FORMAT(created_at, '%Y%m'), DATE_FORMAT(created_at, '%M %Y')
        ORDER BY ym DESC
        LIMIT 6
    ";

    $applicationsPerMonth = collect(DB::select($query))->sortBy('ym');

    $labels = $applicationsPerMonth->pluck('month');
    $data = $applicationsPerMonth->pluck('total');

        return view('admin.dashboard', compact(
            'pending',
            'hired',
            'rejected',
            'activeJobs',
            'latestApplications',
            'labels',
            'data'
        ));
    }
}
