<?php

namespace App\Models;

use App\Models\Majority;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Education extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'grade_uuid' => 'string',
    ];
    protected $fillable = ['majority_uuid', 'school_name', 'graduate_year', 'last_score'];

    // Relasi dengan grade
    public function majority()
    {
        return $this->belongsTo(Majority::class, 'majority_uuid');
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($education){
            if (!$education->id) {
                $education->id = (string) Str::uuid(); // Menetapkan UUID saat pembuatan data
            }
        });
        }

}
