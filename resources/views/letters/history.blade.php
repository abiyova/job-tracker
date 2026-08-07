@extends('layouts.app')
@section('title', 'Riwayat Surat Lamaran')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Surat Lamaran</h1>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteMassModal">
            <i class="bi bi-trash-fill me-1"></i> Hapus Riwayat
        </button>
        <a href="{{ route('letters.index') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Generate Surat Baru
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 fw-semibold border-bottom">
        <i class="bi bi-clock-history me-2 text-primary"></i> Daftar Surat yang Dihasilkan
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 25%">Tanggal Dibuat</th>
                        <th style="width: 30%">Lamaran Pekerjaan</th>
                        <th style="width: 25%">Template yang Digunakan</th>
                        <th style="width: 10%">Format</th>
                        <th style="width: 10%" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($letters as $letter)
                        <tr>
                            <td class="text-secondary small">
                                {{ $letter->generated_at ? \Carbon\Carbon::parse($letter->generated_at)->translatedFormat('d F Y, H:i') : '-' }}
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $letter->job->company_name }}</div>
                                <div class="text-muted small">{{ $letter->job->position }}</div>
                            </td>
                            <td class="text-muted">
                                {{ $letter->template ? $letter->template->name : 'Template dihapus' }}
                            </td>
                            <td>
                                @if($letter->file_type === 'pdf')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                        <i class="bi bi-file-pdf me-1"></i>PDF
                                    </span>
                                @else
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                        <i class="bi bi-file-word me-1"></i>DOCX
                                    </span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('letters.download', $letter->id) }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-download me-1"></i> Unduh
                                    </a>
                                    <form action="{{ route('letters.destroy', $letter->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat surat ini beserta filenya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Riwayat">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-envelope-open fs-1 d-block mb-3 text-secondary"></i>
                                Belum ada riwayat surat lamaran yang di-generate.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($letters->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $letters->links() }}
        </div>
    @endif
</div>

<!-- Modal Hapus Riwayat Massal -->
<div class="modal fade" id="deleteMassModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('letters.destroy-mass') }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Hapus Riwayat Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Pilih metode penghapusan:</label>
                    <select name="delete_type" class="form-select" id="deleteTypeSelect" onchange="toggleDateRange()">
                        <option value="all">Hapus Semua Riwayat</option>
                        <option value="range">Pilih Rentang Tanggal</option>
                    </select>
                </div>
                
                <div id="dateRangeInput" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>
                </div>
                
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Perhatian: File fisik (Word) dari riwayat yang dipilih juga akan ikut terhapus secara permanen.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus Sekarang</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleDateRange() {
    var type = document.getElementById('deleteTypeSelect').value;
    var dateRange = document.getElementById('dateRangeInput');
    var inputs = dateRange.querySelectorAll('input[type="date"]');
    
    if(type === 'range') {
        dateRange.style.display = 'block';
        inputs.forEach(el => el.required = true);
    } else {
        dateRange.style.display = 'none';
        inputs.forEach(el => el.required = false);
    }
}
</script>

@endsection
