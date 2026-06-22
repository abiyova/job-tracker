<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
        'force_password_change', 'is_active', 'application_limit',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    public function jobs()           { return $this->hasMany(Job::class); }
    public function cvs()            { return $this->hasMany(Cv::class); }
    public function profile()        { return $this->hasOne(ApplicantProfile::class); }
    public function letterTemplates(){ return $this->hasMany(LetterTemplate::class); }
    public function loginLogs()      { return $this->hasMany(LoginLog::class); }

    public function isAdmin(): bool  { return $this->role === 'admin'; }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
