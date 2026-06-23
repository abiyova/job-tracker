@extends('layouts.app')
@section('title', 'Edit CV')
@section('breadcrumb', 'CV Saya / Edit')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header fw-semibold">
                <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Informasi CV
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('cvs.update', $cv) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nama CV <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $cv->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Versi / Bahasa</label>
                        <input type="text" name="version" class="form-control @error('version') is-invalid @enderror" 
                               value="{{ old('version', $cv->version) }}">
                        @error('version')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File CV Baru (PDF/Word)</label>
                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf,.doc,.docx">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengganti file. Maksimal 5MB, format PDF/Word.</div>
                        @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $cv->description) }}</textarea>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="is_default" class="form-check-input" id="is_default" value="1" {{ old('is_default', $cv->is_default) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_default">Jadikan sebagai CV Utama (Default)</label>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('cvs.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
