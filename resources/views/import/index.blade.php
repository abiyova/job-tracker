@extends('layouts.app')
@section('title', 'Import Data Lamaran')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold py-3 border-bottom">
                <i class="bi bi-cloud-arrow-up me-2 text-primary"></i> Import Data Lamaran
            </div>
            <div class="card-body p-4">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i> Pastikan file yang diunggah berformat <strong>.xlsx</strong>, <strong>.xls</strong>, atau <strong>.csv</strong>. Maksimal ukuran file adalah 5MB.
                </div>
                
                <div class="mb-4">
                    <h6 class="fw-bold mb-2"><i class="bi bi-table me-1"></i>Panduan Format Kolom (Header pada Baris Pertama)</h6>
                    <div class="table-responsive border rounded">
                        <table class="table table-sm table-striped mb-0 text-sm" style="font-size: 0.85rem;">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Kolom</th>
                                    <th>Status</th>
                                    <th>Keterangan / Contoh</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td><code>company_name</code></td><td><span class="badge bg-danger">Wajib</span></td><td>Nama Perusahaan</td></tr>
                                <tr><td><code>position</code></td><td><span class="badge bg-danger">Wajib</span></td><td>Posisi Pekerjaan</td></tr>
                                <tr><td><code>location</code></td><td><span class="badge bg-secondary">Opsional</span></td><td>Lokasi (kota/negara)</td></tr>
                                <tr><td><code>publish_date</code></td><td><span class="badge bg-secondary">Opsional</span></td><td>Tanggal Loker (format YYYY-MM-DD atau Excel Date)</td></tr>
                                <tr><td><code>source</code></td><td><span class="badge bg-secondary">Opsional</span></td><td>Sumber Info (LinkedIn, Telegram, dll)</td></tr>
                                <tr><td><code>job_url</code></td><td><span class="badge bg-secondary">Opsional</span></td><td>Link Info Loker</td></tr>
                                <tr><td><code>apply_date</code></td><td><span class="badge bg-secondary">Opsional</span></td><td>Tanggal Melamar (format YYYY-MM-DD atau Excel Date)</td></tr>
                                <tr><td><code>status</code></td><td><span class="badge bg-secondary">Opsional</span></td><td>Status. <i>(belum_dilamar, proses_seleksi, ditolak)</i></td></tr>
                                <tr><td><code>notes</code></td><td><span class="badge bg-secondary">Opsional</span></td><td>Catatan Tambahan</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="file" class="form-label fw-medium">Pilih File Data</label>
                        <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" accept=".xlsx, .xls, .csv" required>
                        @error('file')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload me-1"></i> Import Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
