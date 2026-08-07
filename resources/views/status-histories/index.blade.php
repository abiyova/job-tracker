@extends('layouts.app')
@section('title', 'Riwayat Status')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Perubahan Status</h5>
    @if($histories->total() > 0)
    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteHistoryModal">
        <i class="bi bi-trash3 me-1"></i> Hapus Riwayat
    </button>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Perusahaan</th><th>Posisi</th><th>Status Lama</th><th>Status Baru</th><th>Catatan</th><th>Waktu</th></tr>
                </thead>
                <tbody>
                    @forelse($histories as $h)
                    <tr>
                        <td class="fw-semibold">{{ $h->job->company_name }}</td>
                        <td>{{ $h->job->position }}</td>
                        <td>
                            @if($h->old_status)
                                <span class="badge badge-{{ $h->old_status }}">
                                    {{ \App\Models\Job::$statuses[$h->old_status]['label'] ?? $h->old_status }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $h->new_status }}">
                                {{ \App\Models\Job::$statuses[$h->new_status]['label'] ?? $h->new_status }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $h->note ?? '-' }}</td>
                        <td class="text-muted small">{{ $h->changed_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($histories->hasPages())
    <div class="card-footer bg-transparent">{{ $histories->links() }}</div>
    @endif
</div>

{{-- Modal Hapus Riwayat --}}
<div class="modal fade" id="deleteHistoryModal" tabindex="-1" aria-labelledby="deleteHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteHistoryModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Hapus Riwayat Status
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form method="POST" action="{{ route('status-histories.destroy-mass') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Metode Penghapusan:</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="delete_type" id="deleteAll" value="all" checked>
                            <label class="form-check-label" for="deleteAll">
                                Hapus <strong>Semua</strong> Riwayat
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="delete_type" id="deleteRange" value="range">
                            <label class="form-check-label" for="deleteRange">
                                Hapus Berdasarkan <strong>Rentang Tanggal</strong>
                            </label>
                        </div>
                    </div>

                    <div id="dateRangeInput" class="row g-2 d-none">
                        <div class="col-6">
                            <label class="form-label small">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label small">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?');">
                        <i class="bi bi-trash3 me-1"></i> Ya, Hapus Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const radioAll = document.getElementById('deleteAll');
    const radioRange = document.getElementById('deleteRange');
    const rangeContainer = document.getElementById('dateRangeInput');
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    function toggleRange() {
        if (radioRange.checked) {
            rangeContainer.classList.remove('d-none');
            startDate.setAttribute('required', 'required');
            endDate.setAttribute('required', 'required');
        } else {
            rangeContainer.classList.add('d-none');
            startDate.removeAttribute('required');
            endDate.removeAttribute('required');
        }
    }

    if (radioAll && radioRange) {
        radioAll.addEventListener('change', toggleRange);
        radioRange.addEventListener('change', toggleRange);
        toggleRange();
    }
});
</script>
@endpush

@endsection