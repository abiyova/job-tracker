@extends('layouts.app')
@section('title', 'Profil Saya')
@section('content')

<div class="row justify-content-center">
<div class="col-md-9">
<div class="card">
    <div class="card-header fw-semibold">
        <i class="bi bi-person-circle me-2 text-primary"></i>Profil Pelamar
        <small class="text-muted ms-2">Data ini digunakan untuk generate surat lamaran</small>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('profile.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="full_name" class="form-control"
                           value="{{ old('full_name', $profile?->full_name) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="birth_place" class="form-control"
                           value="{{ old('birth_place', $profile?->birth_place) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="birth_date" class="form-control"
                           value="{{ old('birth_date', $profile?->birth_date?->format('Y-m-d')) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $profile?->address) }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone', $profile?->phone) }}" placeholder="+62...">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $profile?->email) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Pendidikan Terakhir</label>
                    <input type="text" name="education" class="form-control"
                           value="{{ old('education', $profile?->education) }}"
                           placeholder="S1 Informatika, Univ. X">
                </div>
                <div class="col-md-4">
                    <label class="form-label"><i class="bi bi-linkedin"></i> LinkedIn</label>
                    <input type="url" name="linkedin" class="form-control"
                           value="{{ old('linkedin', $profile?->linkedin) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label"><i class="bi bi-github"></i> GitHub</label>
                    <input type="url" name="github" class="form-control"
                           value="{{ old('github', $profile?->github) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label"><i class="bi bi-globe"></i> Portfolio</label>
                    <input type="url" name="portfolio" class="form-control"
                           value="{{ old('portfolio', $profile?->portfolio) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Ringkasan Profil</label>
                    <textarea name="summary" class="form-control" rows="4"
                              placeholder="Tuliskan ringkasan profil profesional Anda...">{{ old('summary', $profile?->summary) }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Profil
                </button>
            </div>
        </form>
    </div>
</div>
</div>
</div>

@endsection