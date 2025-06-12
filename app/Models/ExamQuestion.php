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
        'options',
        'correct_answer',
        'points',
    ];

    // Relasi ke judul ujian
    public function examTitle()
    {
        return $this->belongsTo(ExamTitle::class);
    }
}
