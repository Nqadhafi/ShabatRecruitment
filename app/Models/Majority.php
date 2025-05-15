<?php

namespace App\Models;
use Illuminate\Support\Str;
use App\Models\Grade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Majority extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'grade_uuid' => 'string',
    ];
    protected $fillable = ['name', 'grade_uuid'];

    // Relasi dengan grade
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_uuid', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($majority) {
            if (!$majority->id) {
                $majority->id = (string) Str::uuid(); // Menetapkan UUID saat pembuatan data
            }
        });
    }
}
