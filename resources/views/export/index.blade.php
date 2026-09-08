@extends('layouts.app')
@section('title', 'Export Data Lamaran')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold py-3 border-bottom">
                <i class="bi bi-cloud-arrow-down me-2 text-primary"></i> Export Data Lamaran
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('export.download') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="status" class="form-label fw-medium">Status Lamaran (Opsional)</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="belum_dilamar" {{ old('status') == 'belum_dilamar' ? 'selected' : '' }}>Belum Dilamar</option>
                            <option value="sudah_dilamar" {{ old('status') == 'sudah_dilamar' ? 'selected' : '' }}>Sudah Dilamar</option>
                            <option value="diproses" {{ old('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="interview" {{ old('status') == 'interview' ? 'selected' : '' }}>Interview</option>
                            <option value="tes" {{ old('status') == 'tes' ? 'selected' : '' }}>Tes</option>
                            <option value="offering" {{ old('status') == 'offering' ? 'selected' : '' }}>Offering</option>
                            <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="diterima" {{ old('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="perlu_follow_up" {{ old('status') == 'perlu_follow_up' ? 'selected' : '' }}>Perlu Follow Up</option>
                            <option value="tidak_direspon" {{ old('status') == 'tidak_direspon' ? 'selected' : '' }}>Tidak Direspon</option>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label fw-medium">Dari Tanggal (Opsional)</label>
                            <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label fw-medium">Sampai Tanggal (Opsional)</label>
                            <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Format File Output</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" id="formatXlsx" value="xlsx" checked>
                                <label class="form-check-label" for="formatXlsx">
                                    <i class="bi bi-file-excel text-success me-1"></i> Excel (.xlsx)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" id="formatCsv" value="csv">
                                <label class="form-check-label" for="formatCsv">
                                    <i class="bi bi-filetype-csv text-secondary me-1"></i> CSV (.csv)
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-download me-1"></i> Download Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
