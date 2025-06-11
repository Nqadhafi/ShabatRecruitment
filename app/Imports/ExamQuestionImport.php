<?php

namespace App\Imports;

use App\Models\ExamQuestion;
use App\Models\ExamTitle;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
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
        // Validasi manual berdasarkan heading
        $examTitle = ExamTitle::findOrFail($this->examTitleId);

        // Validasi format kolom
        $rules = [
            'soal' => 'required',
            'a' => 'required',
            'b' => 'required',
            'c' => 'required',
            'd' => 'required',
        ];

        if ($examTitle->exam_type === 'benar_salah') {
            $rules['jawaban_benar'] = 'required|in:A,B,C,D';
        } else {
            $rules['poin_a'] = 'required|integer|min:0';
            $rules['poin_b'] = 'required|integer|min:0';
            $rules['poin_c'] = 'required|integer|min:0';
            $rules['poin_d'] = 'required|integer|min:0';
        }

        Validator::make($row, $rules)->validate();

        return new ExamQuestion([
            'exam_title_id' => $this->examTitleId,
            'question_text' => $row['soal'],
            'option_a' => $row['a'],
            'option_b' => $row['b'],
            'option_c' => $row['c'],
            'option_d' => $row['d'],
            'correct_answer' => $examTitle->exam_type === 'benar_salah' ? $row['jawaban_benar'] : null,
            'point_a' => $examTitle->exam_type === 'poin' ? $row['poin_a'] : 0,
            'point_b' => $examTitle->exam_type === 'poin' ? $row['poin_b'] : 0,
            'point_c' => $examTitle->exam_type === 'poin' ? $row['poin_c'] : 0,
            'point_d' => $examTitle->exam_type === 'poin' ? $row['poin_d'] : 0,
        ]);
    }
}