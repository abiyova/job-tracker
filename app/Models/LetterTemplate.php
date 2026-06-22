<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterTemplate extends Model
{
    protected $fillable = ['user_id','name','description','content'];
    public function user() { return $this->belongsTo(User::class); }
}
