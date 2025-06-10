<?php

namespace App\Exports;

use App\Models\ExamQuestion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExamQuestionExport implements FromCollection, WithHeadings
{
    protected $examTitleId;

    public function __construct($examTitleId)
    {
        $this->examTitleId = $examTitleId;
    }

    public function collection()
    {
        return ExamQuestion::where('exam_title_id', $this->examTitleId)->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Soal',
            'A',
            'B',
            'C',
            'D',
            'Jawaban Benar',
            'Poin A',
            'Poin B',
            'Poin C',
            'Poin D'
        ];
    }
}