<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExamTitle;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ExamQuestionRequest;

class ExamQuestionController extends Controller
{
    // Menampilkan daftar soal berdasarkan judul ujian
public function index(ExamTitle $examTitle)
{
    // Ambil daftar pertanyaan dengan paginasi
    $questions = $examTitle->questions()->latest()->paginate(10)->withQueryString();

    // Hitung nomor pertanyaan untuk setiap halaman
    $page = request()->get('page', 1);
    $perPage = 10; // Set jumlah item per halaman
    $startNumber = ($page - 1) * $perPage + 1;

    return view('admin.exam-questions.index', compact('examTitle', 'questions', 'startNumber'));
}

    // Menampilkan form tambah soal
    public function create(ExamTitle $examTitle)
    {
        return view('admin.exam-questions.create', compact('examTitle'));
    }

    // Menyimpan soal baru
        public function store(ExamQuestionRequest $request, ExamTitle $examTitle)
        {

            $data = $request->validated();
    // Upload gambar jika ada
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/exam'), $filename);
                $data['image_path'] = 'exam/' . $filename;
            }

   // Simpan options sebagai JSON
            $data['options'] = json_encode($request->input('options'));

            // Jika tipe benar_salah, validasi correct_answer ada di options
    if ($examTitle->exam_type === 'benar_salah') {
        $data['correct_answer'] = $request->input('correct_answer');

        // Validasi tambahan di sini (opsional)
        $validKeys = array_keys((array) json_decode($data['options'], true));
        if (!in_array($data['correct_answer'], $validKeys)) {
            return back()->withErrors(['correct_answer' => 'Jawaban benar tidak ditemukan di opsi']);
        }
    }

            // Simpan points jika tipe poin
            if ($examTitle->exam_type === 'poin') {
                $data['points'] = json_encode($request->input('points'));
            }

            $examTitle->questions()->create($data);
            return redirect()->route('exam-questions.index', $examTitle)->with('success', 'Soal berhasil ditambahkan.');
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
        $data = $request->validated();
    // Hapus gambar lama jika ada
    $oldImagePath = $examQuestion->image_path;

    if ($request->hasFile('image')) {
        $oldImagePath = $examQuestion->image_path;

        // Hapus gambar lama jika ada
        if ($oldImagePath && file_exists(public_path('images/' . $oldImagePath))) {
            unlink(public_path('images/' . $oldImagePath));
        }

        // Upload gambar baru
        $file = $request->file('image');
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/exam'), $filename);
        $data['image_path'] = 'exam/' . $filename;
    }

    // Simpan options sebagai JSON
        $data['options'] = json_encode($request->input('options'));
    
    // Validasi jawaban benar
        if ($examTitle->exam_type === 'benar_salah') {
        $validKeys = array_keys((array) json_decode($data['options'], true));
        if (!in_array($request->input('correct_answer'), $validKeys)) {
            return back()->withErrors(['correct_answer' => 'Jawaban benar tidak ditemukan di opsi']);
        }
    }

    // Simpan points jika tipe poin
    if ($examTitle->exam_type === 'poin') {
        $data['points'] = json_encode($request->input('points'));
    }
    $examQuestion->update($data);
        return redirect()->route('exam-questions.index', $examTitle)->with('success', 'Soal berhasil diubah.');
    }

    // Menghapus soal
    public function destroy(ExamTitle $examTitle, ExamQuestion $examQuestion)
    {
            if ($examQuestion->image_path && File::exists(public_path('images/' . $examQuestion->image_path))) {
        File::delete(public_path('images/' . $examQuestion->image_path));
    }
        $examQuestion->delete();
        return redirect()->route('exam-questions.index', $examTitle)->with('success', 'Soal berhasil dihapus.');
    }
}