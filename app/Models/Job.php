<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name', 'requirement', 'description', 'photo_path', 'is_active'];

        // Saat menyimpan data, otomatis menambahkan UUID
        protected static function boot()
        {
            parent::boot();
    
            static::creating(function ($job) {
                if (!$job->id) {
                    $job->id = (string) Str::uuid(); // Menetapkan UUID saat pembuatan data
                }
            });
        }
}
