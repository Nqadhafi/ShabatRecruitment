<?php

namespace App\Exports;

use App\Models\ExamTitle;
use Illuminate\Support\Arr;
use App\Models\ExamQuestion;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;

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
    return ExamQuestion::where('exam_title_id', $this->examTitleId)
        ->with(['examTitle'])
        ->get()
        ->map(function ($item) {
            $options = json_decode($item->options, true) ?: [];

            $row = [
                'soal' => $item->question_text,
            ];

            foreach (array_keys($options) as $key) {
                $row[ strtolower($key) ] = $options[$key];
            }

            if ($item->examTitle->exam_type === 'benar_salah') {
                $row['jawaban_benar'] = $item->correct_answer;
            }

            if ($item->examTitle->exam_type === 'poin') {
                $points = json_decode($item->points, true) ?: [];
                foreach (array_keys($options) as $key) {
                    $row['poin_' . strtolower($key)] = Arr::get($points, strtoupper($key), 0);
                }
            }

            return $row;
        });
}

public function headings(): array
{
    $examTitle = ExamTitle::find($this->examTitleId);

    // Ambil semua soal untuk cari maksimum opsi jawaban
    $allOptions = ExamQuestion::where('exam_title_id', $this->examTitleId)->get()->flatMap(function ($q) {
        return array_keys(json_decode($q->options, true));
    })->unique()->sort();

    // Buat heading jawaban
    $optionHeaders = $allOptions->map(fn($key) => strtolower($key))->toArray();
    $pointHeaders = $allOptions->map(fn($key) => 'poin_' . strtolower($key))->toArray();

    // Gabungkan semua heading
    $base = ['soal'];
    $headers = array_merge($base, $optionHeaders);

    if ($examTitle->exam_type === 'benar_salah') {
        $headers[] = 'jawaban_benar';
    }

    if ($examTitle->exam_type === 'poin') {
        $headers = array_merge($headers, $pointHeaders);
    }

    return $headers;
}
}