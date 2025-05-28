<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\ApplicantProfile;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['email', 'password', 'profiles_uuid', 'role'];
    public function applicantProfile()
    {
        return $this->hasOne(ApplicantProfile::class, 'id', 'profiles_uuid');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'profiles_uuid' => 'string',
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (!$user->id) {
                $user->id = (string) Str::uuid(); // Menetapkan UUID saat pembuatan data
            }
        });
    }
}
