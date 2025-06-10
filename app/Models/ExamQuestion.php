<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;
        protected $fillable = [
        'exam_title_id',
        'question_text',
        'image_path',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'point_a',
        'point_b',
        'point_c',
        'point_d',
    ];

    // Relasi ke judul ujian
    public function examTitle()
    {
        return $this->belongsTo(ExamTitle::class);
    }
}
