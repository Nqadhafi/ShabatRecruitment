<?php

namespace App\Models;

use App\Models\Education;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
