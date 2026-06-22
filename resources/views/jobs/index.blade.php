@extends('layouts.app')
@section('title', 'Data Lamaran')
@section('breadcrumb', 'Lamaran / Daftar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold">
        <i class="bi bi-file-earmark-text me-2 text-primary"></i>Data Lamaran
    </h5>
    <div class="d-flex gap-2 align-items-center">
        <form method="POST" action="{{ route('jobs.check-followup') }}" class="m-0">
            @csrf
            <button type="submit" class="btn btn-outline-warning" title="Cek status otomatis (2-3 minggu)">
                <i class="bi bi-arrow-repeat me-1"></i> Sinkronisasi Follow Up
            </button>
        </form>
        @if(($perPage === 'all' ? $jobs->count() : $jobs->total()) > 0)
        <button type="button" class="btn btn-outline-danger m-0" data-bs-toggle="modal" data-bs-target="#deleteAllModal">
            <i class="bi bi-trash3 me-1"></i> Hapus Semua
        </button>
        @endif
        @if($limitStatus['has_limit'])
            <span class="badge {{ $limitStatus['can_add'] ? 'bg-info' : 'bg-danger' }} fs-6 px-3 py-2 border">
                Limit: {{ $limitStatus['current'] }} / {{ $limitStatus['limit'] }}
            </span>
        @endif
        @if($limitStatus['can_add'])
            <a href="{{ route('jobs.create') }}" class="btn btn-primary m-0">
                <i class="bi bi-plus-lg me-1"></i> Tambah Lamaran
            </a>
        @else
            <button class="btn btn-secondary m-0" disabled title="Batas maksimal lamaran tercapai">
                <i class="bi bi-plus-lg me-1"></i> Tambah Lamaran
            </button>
        @endif
    </div>
</div>

{{-- Filter & Search --}}
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('jobs.index') }}" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label small text-muted mb-1">Cari</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Perusahaan / posisi..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $key => $s)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                            {{ $s['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted mb-1">Urutan Tgl Lamar</label>
                <select name="dir" class="form-select">
                    <option value="desc" {{ request('dir')=='desc' ? 'selected' : '' }}>Terbaru (↓)</option>
                    <option value="asc"  {{ request('dir')=='asc'  ? 'selected' : '' }}>Terlama (↑)</option>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label small text-muted mb-1">Per Hal</label>
                <select name="per_page" class="form-select">
                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request('per_page','15') == '15' ? 'selected' : '' }}>15</option>
                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Semua</option>
                </select>
            </div>
            <div class="col-md-1 d-flex gap-2 align-items-end">
                <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
            </div>
            <div class="col-auto d-flex align-items-end">
                <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Perusahaan</th>
                        <th>Posisi & Lokasi</th>
                        <th>Sumber</th>
                        <th>Tgl Publikasi</th>
                        <th>Tgl Lamar</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $i => $job)
                                         
                    <tr>
                        <td class="text-muted small">{{ $perPage === 'all' ? $i + 1 : $jobs->firstItem() + $i }}</td>
                        <td>
                            <div class="fw-semibold">{{ $job->company_name }}</div>
                            @if($job->job_url)
                                <a href="{{ $job->job_url }}" target="_blank" class="text-muted small">
                                    <i class="bi bi-link-45deg"></i> Link Loker
                                </a>
                            @endif
                        </td>
                        <td>
                            <div class="fw-medium">{{ $job->position }}</div>
                            @if($job->location)
                                <div class="small text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $job->location }}</div>
                            @endif
                        </td>
                        <td><span class="text-muted">{{ $job->source ?? '-' }}</span></td>
                        <td class="small">{{ $job->publish_date?->format('d M Y') ?? '-' }}</td>
                        <td class="small">{{ $job->apply_date?->format('d M Y') ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $job->status }} px-2 py-1">
                                {{ $job->status_label }}
                            </span>
                        </td>
                        <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('jobs.show', $job) }}"
                            class="btn btn-sm btn-outline-secondary" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('jobs.edit', $job) }}"
                            class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form method="POST"
                                action="{{ route('jobs.destroy', $job) }}"
                                class="m-0"
                                onsubmit="return confirm('Hapus lamaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox display-6 d-block mb-2"></i>
                            Tidak ada data lamaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($perPage !== 'all' && $jobs->hasPages())
    <div class="card-footer border-top-0 bg-transparent pt-3 d-flex justify-content-center">
        {{ $jobs->links() }}
    </div>
    @endif
</div>
{{-- Modal Konfirmasi Hapus Semua --}}
<div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAllModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus Semua Data
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning mb-3">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    <strong>Perhatian!</strong> Tindakan ini akan menghapus <strong>seluruh data lamaran</strong> Anda secara permanen dan tidak dapat dikembalikan.
                </div>
                <p class="mb-2">Ketik <strong class="text-danger">HAPUS</strong> di bawah ini untuk mengonfirmasi:</p>
                <input type="text" id="confirmDeleteInput" class="form-control" placeholder="Ketik HAPUS di sini..." autocomplete="off">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="{{ route('jobs.destroy-all') }}" id="deleteAllForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn" disabled>
                        <i class="bi bi-trash3 me-1"></i> Ya, Hapus Semua
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('confirmDeleteInput');
    const btn = document.getElementById('confirmDeleteBtn');
    if (input && btn) {
        input.addEventListener('input', function () {
            btn.disabled = this.value.trim() !== 'HAPUS';
        });
    }
    const modal = document.getElementById('deleteAllModal');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function () {
            if (input) { input.value = ''; }
            if (btn) { btn.disabled = true; }
        });
    }
});
</script>
@endsection