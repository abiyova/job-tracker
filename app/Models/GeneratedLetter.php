<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedLetter extends Model
{
    public $timestamps = false;
    protected $fillable = ['job_id','template_id','file_name','file_type','file_path','generated_at'];
    public function job()      { return $this->belongsTo(Job::class); }
    public function template() { return $this->belongsTo(LetterTemplate::class); }
}
