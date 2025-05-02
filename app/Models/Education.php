<?php

namespace App\Models;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Education extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['grade_uuid', 'school_name', 'graduate_year', 'last_score'];

    // Relasi dengan grade
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_uuid');
    }
}
