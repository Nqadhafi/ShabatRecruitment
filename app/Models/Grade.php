<?php

namespace App\Models;

use App\Models\Majority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name'];

    // Relasi dengan majority
    public function majorities()
    {
        return $this->hasMany(Majority::class, 'grade_uuid');
    }
}
