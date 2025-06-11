<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamTitle extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'exam_type',
        'is_active',
        'is_random',
        'duration_minutes'
    ];

    // Relasi ke soal
    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }
}
