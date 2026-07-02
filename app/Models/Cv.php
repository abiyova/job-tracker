<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $fillable = ['user_id','name','description','version','file_path','file_path_docx','is_default'];
    public function user() { return $this->belongsTo(User::class); }
}
