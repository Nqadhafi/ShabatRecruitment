<?php

namespace App\Models;

use App\Models\Education;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ApplicantProfile extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'education_uuid' => 'string',
    ];
    
    protected $fillable = ['full_name', 'surname', 'ktp_number', 'address', 'phone_number', 'photo_path', 'instagram_surname', 'linkedin_surname', 'education_uuid'];

    public function education()
    {
        return $this->belongsTo(Education::class, 'education_uuid');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id', 'profiles_uuid');
    }

        protected static function boot()
    {
        parent::boot();

        static::creating(function ($applicantProfile) {
            if (!$applicantProfile->id) {
                $applicantProfile->id = (string) Str::uuid(); // Menetapkan UUID saat pembuatan data
            }
        });
        }

}
