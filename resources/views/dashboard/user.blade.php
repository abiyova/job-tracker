@extends('layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card" style="background: linear-gradient(135deg,#4361ee,#3a0ca3)">
            <div class="stat-icon"><i class="bi bi-file-earmark-text"></i></div>
            <div class="stat-number">{{ $stats['total_lamaran'] }}</div>
            <div class="stat-label">Total Lamaran</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card" style="background: linear-gradient(135deg,#f77f00,#d62828)">
            <div class="stat-icon"><i class="bi bi-camera-video"></i></div>
            <div class="stat-number">{{ $stats['interview'] }}</div>
            <div class="stat-label">Interview</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card" style="background: linear-gradient(135deg,#0077b6,#023e8a)">
            <div class="stat-icon"><i class="bi bi-pencil-square"></i></div>
            <div class="stat-number">{{ $stats['tes'] }}</div>
            <div class="stat-label">Tes</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card" style="background: linear-gradient(135deg,#2dc653,#008000)">
            <div class="stat-icon"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-number">{{ $stats['offering'] }}</div>
            <div class="stat-label">Offering</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card" style="background: linear-gradient(135deg,#e63946,#9d0208)">
            <div class="stat-icon"><i class="bi bi-x-circle"></i></div>
            <div class="stat-number">{{ $stats['ditolak'] }}</div>
            <div class="stat-label">Ditolak</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card" style="background: linear-gradient(135deg,#06d6a0,#1b4332)">
            <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
            <div class="stat-number">{{ $stats['diterima'] }}</div>
            <div class="stat-label">Diterima</div>
        </div>
    </div>
</div>

{{-- Charts Row --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header fw-semibold">
                <i class="bi bi-pie-chart me-2 text-primary"></i>Status Lamaran
            </div>
            <div class="card-body" style="position: relative; height: 250px; width: 100%;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header fw-semibold">
                <i class="bi bi-bar-chart me-2 text-primary"></i>Lamaran per Bulan
            </div>
            <div class="card-body" style="position: relative; height: 250px; width: 100%;">
                <canvas id="bulanChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Recent Jobs --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-clock-history me-2 text-primary"></i>Lamaran Terbaru</span>
        <a href="{{ route('jobs.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Perusahaan</th>
                        <th>Posisi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentJobs as $job)
                    <tr>
                        <td class="fw-semibold">{{ $job->company_name }}</td>
                        <td>{{ $job->position }}</td>
                        <td class="text-muted small">{{ $job->apply_date?->format('d M Y') ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $job->status }}">{{ $job->status_label }}</span>
                        </td>
                        <td>
                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-xs btn-outline-secondary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Belum ada lamaran. <a href="{{ route('jobs.create') }}">Tambah sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Status Chart (Doughnut)
const statusData = @json($lamaranPerStatus);
const statusColors = {
    belum_dilamar:'#6c757d', sudah_dilamar:'#0d6efd', diproses:'#0dcaf0',
    interview:'#ffc107', tes:'#fd7e14', offering:'#198754',
    ditolak:'#dc3545', diterima:'#20c997'
};
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: statusData.map(d => d.status),
        datasets: [{
            data: statusData.map(d => d.total),
            backgroundColor: statusData.map(d => statusColors[d.status] || '#999'),
        }]
    },
    options: { plugins: { legend: { position: 'bottom' } }, cutout: '60%', maintainAspectRatio: false }
});

// Bulan Chart (Bar)
const bulanData = @json($lamaranPerBulan);
const bulanNames = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
new Chart(document.getElementById('bulanChart'), {
    type: 'bar',
    data: {
        labels: bulanData.map(d => bulanNames[d.bulan]),
        datasets: [{
            label: 'Lamaran',
            data: bulanData.map(d => d.total),
            backgroundColor: '#4361ee88',
            borderColor: '#4361ee',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } }, maintainAspectRatio: false }
});
</script>
@endpush