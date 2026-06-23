@extends('layouts.app')
@section('title', 'Unggah CV')
@section('breadcrumb', 'CV Saya / Unggah')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header fw-semibold">
                <i class="bi bi-upload me-2 text-primary"></i>Unggah CV Baru
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('cvs.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Nama CV <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="Misal: CV Frontend Developer" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Versi / Bahasa</label>
                        <input type="text" name="version" class="form-control @error('version') is-invalid @enderror" 
                               value="{{ old('version') }}" placeholder="Misal: v2.0, Bahasa Inggris">
                        @error('version')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File CV (PDF/Word) <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf,.doc,.docx" required>
                        <div class="form-text">Maksimal 5MB, format wajib PDF, DOC, atau DOCX.</div>
                        @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Opsional...">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="is_default" class="form-check-input" id="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_default">Jadikan sebagai CV Utama (Default)</label>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan & Unggah
                        </button>
                        <a href="{{ route('cvs.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
