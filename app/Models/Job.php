<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'job_applications';
    protected $fillable = [
        'user_id','company_name','position','location','publish_date',
        'source','job_url','apply_date','status','notes',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'apply_date'   => 'date',
    ];

    // Status label & badge color helper
    public static array $statuses = [
        'belum_dilamar'   => ['label' => 'Belum Dilamar',   'badge' => 'secondary'],
        'sudah_dilamar'   => ['label' => 'Sudah Dilamar',   'badge' => 'primary'],
        'diproses'        => ['label' => 'Diproses',        'badge' => 'info'],
        'interview'       => ['label' => 'Interview',       'badge' => 'warning'],
        'tes'             => ['label' => 'Tes',             'badge' => 'warning'],
        'offering'        => ['label' => 'Offering',        'badge' => 'success'],
        'ditolak'         => ['label' => 'Ditolak',         'badge' => 'danger'],
        'diterima'        => ['label' => 'Diterima',        'badge' => 'success'],
        'perlu_follow_up' => ['label' => 'Perlu Follow Up', 'badge' => 'warning'],
        'tidak_direspon'  => ['label' => 'Tidak Direspon',  'badge' => 'danger'],
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::$statuses[$this->status]['label'] ?? $this->status;
    }

    public function getStatusBadgeAttribute(): string
    {
        return self::$statuses[$this->status]['badge'] ?? 'secondary';
    }

    public function user()             { return $this->belongsTo(User::class); }
    public function statusHistories()  { return $this->hasMany(StatusHistory::class); }
    public function generatedLetters() { return $this->hasMany(GeneratedLetter::class); }
}
