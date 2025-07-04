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
$sub = DB::table('applications')
    ->selectRaw("DATE_FORMAT(created_at, '%Y%m') as ym, COUNT(*) as total")
    ->groupByRaw("DATE_FORMAT(created_at, '%Y%m')");

$applicationsPerMonth = DB::table(DB::raw("({$sub->toSql()}) as sub"))
    ->mergeBindings($sub) // penting untuk menghindari binding error
    ->select('ym', DB::raw("DATE_FORMAT(STR_TO_DATE(CONCAT(ym,'01'), '%Y%m%d'), '%M %Y') as month"), 'total')
    ->orderBy('ym')
    ->take(6)
    ->get();

        // Persiapkan data untuk grafik


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
