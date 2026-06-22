<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    public $timestamps = false;
    protected $fillable = ['job_id','old_status','new_status','note','changed_at'];
    protected $casts    = ['changed_at' => 'datetime'];
    public function job() { return $this->belongsTo(Job::class); }
}
