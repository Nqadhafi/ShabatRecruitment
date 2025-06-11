<?php

namespace App\Exports;

use App\Models\ExamQuestion;
use App\Models\ExamTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExamQuestionExport implements FromCollection, WithHeadings
{
    protected $examTitleId;
    protected $examType;

    public function __construct($examTitleId)
    {
        $this->examTitleId = $examTitleId;

        // Ambil tipe soal dari model ExamTitle
        $examTitle = ExamTitle::findOrFail($examTitleId);
        $this->examType = $examTitle->exam_type; // 'benar_salah' atau 'poin'
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ExamQuestion::where('exam_title_id', $this->examTitleId)->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $baseHeaders = [
            'Nomor Soal (Angka)',
            'Soal',
            'Jawaban A',
            'Jawaban B',
            'Jawaban C',
            'Jawaban D',
        ];

        if ($this->examType === 'benar_salah') {
            return array_merge($baseHeaders, ['Jawaban Benar (contoh: B)']);
        } else {
            return array_merge($baseHeaders, [
                'Poin A (0-100)',
                'Poin B (0-100)',
                'Poin C (0-100)',
                'Poin D (0-100)'
            ]);
        }
    }
}