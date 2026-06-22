@extends('layouts.app')
@section('title', 'Pengaturan Sistem')
@section('breadcrumb', 'Pengaturan Sistem')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-gear me-2 text-primary"></i>Pengaturan Sistem</h5>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            
            <div class="mb-4">
                <label class="form-label fw-bold">Batas Lamaran Default untuk Pengguna Baru</label>
                <div class="input-group" style="max-width: 300px;">
                    <input type="number" name="default_application_limit" class="form-control" value="{{ $settings['default_application_limit'] ?? '' }}" placeholder="Biarkan kosong untuk tak terbatas" min="1">
                    <span class="input-group-text">lamaran</span>
                </div>
                <div class="form-text">Batas maksimum jumlah lamaran yang bisa dibuat oleh user yang baru mendaftar. Biarkan kosong jika ingin dibuat tak terbatas (unlimited).</div>
            </div>

            <!-- Other settings like app_name can be placed here if needed -->
            
            <hr>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Pengaturan</button>
        </form>
    </div>
</div>

@endsection
