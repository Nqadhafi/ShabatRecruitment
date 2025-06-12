<?php

namespace App\Imports;

use App\Models\ExamTitle;
use App\Models\ExamQuestion;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExamQuestionImport implements ToModel, WithHeadingRow
{
    protected $examTitleId;

    public function __construct($examTitleId)
    {
        $this->examTitleId = $examTitleId;
    }

    public function model(array $row)
{
    $examTitle = ExamTitle::findOrFail($this->examTitleId);

    // Ambil semua key alfabet (a, b, c, d, e, f...) dari heading Excel
    $validKeys = array_filter(array_keys($row), function ($key) {
        return preg_match('/^[a-zA-Z]$/', $key); // hanya huruf tunggal (a, b, c...)
    });

    // Buat array opsi jawaban dinamis
    $options = [];
    foreach ($validKeys as $key) {
        $value = $row[$key] ?? null;
        if ($value !== null && $value !== '') {
            $options[ strtoupper($key) ] = $value;
        }
    }

    // Validasi minimal 2 jawaban
    if (count($options) < 2) {
        $error = new MessageBag([
            'import' => 'Soal harus memiliki minimal 2 jawaban. Pastikan jumlah kolom a-z cukup.'
        ]);
        throw ValidationException::withMessages([
            'import' => ['Soal harus memiliki minimal 2 jawaban']
        ]);
    }

    // Validasi jawaban benar harus ada di dalam options
    $rules = [
        'soal' => 'required|string',
    ];

    if ($examTitle->exam_type === 'benar_salah') {
        $rules['jawaban_benar'] = [
            'required',
            Rule::in(array_keys($options))
        ];
    }

    if ($examTitle->exam_type === 'poin') {
        foreach ($validKeys as $key) {
            $rules["poin_" . strtolower($key)] = 'required|integer|min:0';
        }
    }

    // Jalankan validasi dan tangkap error
    $validator = Validator::make($row, $rules);

    if ($validator->fails()) {
        $message = "Ada beberapa kesalahan pada baris ini:\n";
        foreach ($validator->errors()->all() as $error) {
            $message .= "- $error\n";
        }

        // Lemparkan error sebagai exception agar proses stop
        Session::flash('error', $message);
        throw new \Exception($message);
    }

    // Lanjutkan jika validasi lolos
    $points = [];
    if ($examTitle->exam_type === 'poin') {
        foreach ($validKeys as $key) {
            $points[strtoupper($key)] = $row["poin_" . strtolower($key)] ?? 0;
        }
    }

    return new ExamQuestion([
        'exam_title_id' => $this->examTitleId,
        'question_text' => $row['soal'],
        'options' => json_encode($options),
        'correct_answer' => $examTitle->exam_type === 'benar_salah' ? strtoupper($row['jawaban_benar']) : null,
        'points' => $examTitle->exam_type === 'poin' ? json_encode($points) : null,
    ]);
}
}