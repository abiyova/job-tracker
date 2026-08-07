<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantProfile extends Model
{
    protected $fillable = [
        'user_id','full_name','birth_place','birth_date','address',
        'phone','email','linkedin','github','portfolio','education','summary',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user() { return $this->belongsTo(User::class); }
}
