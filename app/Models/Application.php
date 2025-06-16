<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $table = 'applications';
    protected $primaryKey = 'id';
    public $incrementing = false; // karena ID menggunakan UUID
    protected $keyType = 'string'; // agar Eloquent tahu bahwa primary key adalah string

    protected $fillable = [
        'job_id',
        'applicant_profile_id',
        'status',
        'cv_path',
        'pakelaring_path',
        'transkrip_path',
        'sertifikat_path'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke lowongan (Job)
     */
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    /**
     * Relasi ke profil pelamar (ApplicantProfile)
     */
    public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class, 'applicant_profile_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($application) {
            if (!$application->id) {
                $application->id = (string) \Illuminate\Support\Str::uuid(); // Menetapkan UUID saat pembuatan data
            }
        });
    }
}
