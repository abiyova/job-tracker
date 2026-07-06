@extends('layouts.app')
@section('title', 'Detail Lamaran')
@section('breadcrumb', 'Lamaran / Detail')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold"><i class="bi bi-info-circle me-2 text-primary"></i>Informasi Lamaran</span>
                <div>
                    <a href="{{ route('jobs.edit', $job) }}" class="btn-modern btn-outline-modern me-2">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('jobs.index') }}" class="btn-modern btn-outline-modern">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Perusahaan</div>
                    <div class="col-md-8 fw-semibold">{{ $job->company_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Posisi</div>
                    <div class="col-md-8">{{ $job->position }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Lokasi Penempatan</div>
                    <div class="col-md-8">{{ $job->location ?: '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Status Saat Ini</div>
                    <div class="col-md-8">
                        <span class="badge badge-{{ $job->status }}">{{ $job->status_label }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Tanggal Melamar</div>
                    <div class="col-md-8">{{ $job->apply_date ? $job->apply_date->format('d M Y') : '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Sumber Info Loker</div>
                    <div class="col-md-8">{{ $job->source ?: '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">URL Info Loker</div>
                    <div class="col-md-8">
                        @if($job->job_url)
                            <a href="{{ $job->job_url }}" target="_blank" class="text-break">{{ $job->job_url }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted">Catatan</div>
                    <div class="col-md-8 text-break">{!! nl2br(e($job->notes)) ?: '-' !!}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header fw-semibold">
                <i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Status
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($histories as $history)
                        <li class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">
                                    <span class="badge badge-{{ $history->new_status }}">
                                        {{ \App\Models\Job::$statuses[$history->new_status]['label'] ?? $history->new_status }}
                                    </span>
                                </h6>
                                <small class="text-muted">{{ $history->changed_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1 small">{{ $history->note }}</p>
                            <small class="text-muted">{{ $history->changed_at->format('d M Y H:i') }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted py-3">
                            Belum ada riwayat status.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
