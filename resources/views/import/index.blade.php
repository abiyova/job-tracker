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
