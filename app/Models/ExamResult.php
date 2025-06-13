<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;
        protected $fillable = [
        'exam_title_id',
        'user_id',
        'score',
        'started_at',
        'finished_at'
    ];

    public function examTitle()
    {
        return $this->belongsTo(ExamTitle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
