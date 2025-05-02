<?php

namespace App\Models;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Majority extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name', 'grade_uuid'];

    // Relasi dengan grade
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_uuid');
    }
}
