<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExamQuestionExport;
use App\Imports\ExamQuestionImport;
use App\Models\ExamTitle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class ExamImportController extends Controller
{
    public function form(ExamTitle $examTitle)
    {
        
        return view('admin.exam-questions.import', compact('examTitle'));
    }

public function import(Request $request, ExamTitle $examTitle)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);
    
    try {
        // Hapus semua soal lama di judul ini
        $examTitle->questions()->delete();

        // Lalu import soal baru
        Excel::import(new ExamQuestionImport($examTitle->id), $request->file('file'));

        return redirect()->route('exam-questions.index', $examTitle)->with('success', 'Soal berhasil diimpor ulang');
    } catch (\Exception $e) {
        return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
}

    public function export(ExamTitle $examTitle)
    {
        return Excel::download(new ExamQuestionExport($examTitle->id), 'soal-'.$examTitle->title.'.xlsx');
    }
}