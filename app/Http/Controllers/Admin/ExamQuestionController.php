<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExamQuestion;
use App\Models\ExamTitle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExamQuestionRequest;

class ExamQuestionController extends Controller
{
    // Menampilkan daftar soal berdasarkan judul ujian
    public function index(ExamTitle $examTitle)
    {
        $questions = $examTitle->questions()->latest()->paginate(10);
        return view('admin.exam-questions.index', compact('examTitle', 'questions'));
    }

    // Menampilkan form tambah soal
    public function create(ExamTitle $examTitle)
    {
        return view('admin.exam-questions.create', compact('examTitle'));
    }

    // Menyimpan soal baru
        public function store(ExamQuestionRequest $request, ExamTitle $examTitle)
        {
            $examTitle->questions()->create($request->validated());
            return redirect()->route('admin.exam-questions.index', $examTitle)->with('success', 'Soal berhasil ditambahkan.');
        }

    // Menampilkan detail soal
    public function show(ExamTitle $examTitle, ExamQuestion $examQuestion)
    {
        return view('admin.exam-questions.show', compact('examTitle', 'examQuestion'));
    }

    // Menampilkan form edit soal
    public function edit(ExamTitle $examTitle, ExamQuestion $examQuestion)
    {
        return view('admin.exam-questions.edit', compact('examTitle', 'examQuestion'));
    }

    // Mengupdate soal
    public function update(ExamQuestionRequest $request, ExamTitle $examTitle, ExamQuestion $examQuestion)
    {
        $examQuestion->update($request->validated());
        return redirect()->route('admin.exam-questions.index', $examTitle)->with('success', 'Soal berhasil diubah.');
    }

    // Menghapus soal
    public function destroy(ExamTitle $examTitle, ExamQuestion $examQuestion)
    {
        $examQuestion->delete();
        return redirect()->route('admin.exam-questions.index', $examTitle)->with('success', 'Soal berhasil dihapus.');
    }
}