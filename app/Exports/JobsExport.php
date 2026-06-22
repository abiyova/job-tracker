<?php

namespace App\Exports;

use App\Models\Job;
use Maatwebsite\Excel\Concerns\{FromQuery, WithHeadings, WithMapping, ShouldAutoSize};

class JobsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(private array $filters = []) {}

    public function query()
    {
        $q = Job::where('user_id', auth()->id());
        if (!empty($this->filters['status'])) {
            $q->where('status', $this->filters['status']);
        }
        return $q->orderByDesc('created_at');
    }

    public function headings(): array
    {
        return ['ID','Perusahaan','Posisi','Lokasi','Sumber','URL Loker',
                'Tgl Publikasi','Tgl Melamar','Status','Catatan','Dibuat'];
    }

    public function map($job): array
    {
        return [
            $job->id,
            $job->company_name,
            $job->position,
            $job->location,
            $job->source,
            $job->job_url,
            $job->publish_date?->format('Y-m-d'),
            $job->apply_date?->format('Y-m-d'),
            \App\Models\Job::$statuses[$job->status]['label'] ?? $job->status,
            $job->notes,
            $job->created_at->format('Y-m-d H:i'),
        ];
    }
}