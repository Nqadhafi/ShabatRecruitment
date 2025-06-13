<?php

namespace App\Http\Controllers;
use App\Models\ExamTitle;
use Illuminate\Support\Facades\Auth;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class ExamStartController extends Controller
{
public function start()
{
    // Ambil semua judul ujian yang aktif
    $activeTitles = ExamTitle::where('is_active', true)->orderBy('id')->get();

    if ($activeTitles->isEmpty()) {
        abort(404, 'Tidak ada ujian aktif saat ini.');
    }

    // Cek apakah user sudah kerja ujian ini
    foreach ($activeTitles as $title) {
        $existing = ExamResult::where('exam_title_id', $title->id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$existing) {
            // Temukan ujian pertama yang belum dikerjakan
            dd($title);
            return redirect()->route('applicant.exam.run', ['examTitle' => $title->id]);
        }
    }

    // Semua ujian sudah dikerjakan
    return view('applicant.exam.all-done');
}
}
