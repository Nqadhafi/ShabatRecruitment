<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExamTitle;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ExamTitleRequest;

class ExamTitleController extends Controller
{
    // Menampilkan daftar semua judul ujian
    public function index()
    {
        $examTitles = ExamTitle::latest()->paginate(10);
        return view('admin.exam-titles.index', compact('examTitles'));
    }

    // Menampilkan form tambah judul ujian
    public function create()
    {
        return view('admin.exam-titles.create');
    }

    // Menyimpan judul ujian baru
        public function store(ExamTitleRequest $request)
        {
            ExamTitle::create($request->validated());
            return redirect()->route('exam-titles.index')->with('success', 'Judul ujian berhasil ditambahkan.');
        }

    // Menampilkan detail judul ujian
    public function show(ExamTitle $examTitle)
    {
        return view('admin.exam-titles.show', compact('examTitle'));
    }

    // Menampilkan form edit judul ujian
    public function edit(ExamTitle $examTitle)
    {
        return view('admin.exam-titles.edit', compact('examTitle'));
    }

    // Mengupdate judul ujian
    public function update(ExamTitleRequest $request, ExamTitle $examTitle)
    {
        $examTitle->update($request->validated());
        return redirect()->route('exam-titles.index')->with('success', 'Judul ujian berhasil diubah.');
    }

    // Menghapus judul ujian
public function destroy(ExamTitle $examTitle)
{
    // Ambil semua soal dalam judul ujian ini
    $questions = $examTitle->questions;

    // Hapus semua gambar dari soal
    foreach ($questions as $question) {
        if ($question->image_path && File::exists(public_path('images/' . $question->image_path))) {
            File::delete(public_path('images/' . $question->image_path));
        }
    }

    // Hapus semua soal (ini akan otomatis terhapus jika examTitle di-delete karena foreignId)
    // Tapi kalau kamu ingin eksplisit:
    ExamQuestion::where('exam_title_id', $examTitle->id)->delete();

    // Hapus judul ujian
    $examTitle->delete();

    return redirect()->route('exam-titles.index')->with('success', 'Judul ujian dan semua soal/gambar terkait berhasil dihapus.');
}
}