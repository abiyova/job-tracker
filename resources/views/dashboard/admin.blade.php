@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('breadcrumb', 'Dashboard Admin')

@section('content')

{{-- Welcome Message --}}
<div class="card bg-primary text-white shadow-sm border-0 mb-4">
    <div class="card-body p-4 d-flex align-items-center">
        <div class="me-3">
            <i class="bi bi-shield-lock fs-1"></i>
        </div>
        <div>
            <h4 class="mb-1 fw-bold">Selamat datang di Panel Admin</h4>
            <p class="mb-0 opacity-75">Kelola pengguna, batasan sistem, dan pengaturan aplikasi Job Tracker.</p>
        </div>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#4361ee,#3a0ca3)">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div class="stat-number">{{ $stats['total_user'] }}</div>
            <div class="stat-label">Total Pengguna</div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#2dc653,#008000)">
            <div class="stat-icon"><i class="bi bi-person-check"></i></div>
            <div class="stat-number">{{ $stats['active_user'] }}</div>
            <div class="stat-label">Pengguna Aktif</div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#f77f00,#d62828)">
            <div class="stat-icon"><i class="bi bi-person-badge"></i></div>
            <div class="stat-number">{{ $stats['admin_user'] }}</div>
            <div class="stat-label">Total Admin</div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#0077b6,#023e8a)">
            <div class="stat-icon"><i class="bi bi-person"></i></div>
            <div class="stat-number">{{ $stats['regular_user'] }}</div>
            <div class="stat-label">Pengguna Biasa</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-white fw-bold py-3">
                <i class="bi bi-people-fill text-primary me-2"></i> Akses Cepat
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-sm-6">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary w-100 text-start p-3 h-100">
                            <i class="bi bi-person-gear me-2"></i> Kelola Pengguna & Batas
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary w-100 text-start p-3 h-100">
                            <i class="bi bi-gear-fill me-2"></i> Pengaturan Sistem
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
