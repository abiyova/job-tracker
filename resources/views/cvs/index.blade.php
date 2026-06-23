@extends('layouts.app')
@section('title', 'Manajemen CV')
@section('breadcrumb', 'CV Saya')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-file-earmark-person me-2 text-primary"></i>Koleksi Curriculum Vitae</span>
        <a href="{{ route('cvs.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-upload me-1"></i> Unggah CV
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama CV</th>
                        <th>Versi</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Diunggah</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cvs as $cv)
                        <tr>
                            <td class="fw-semibold">
                                @php
                                    $ext = pathinfo($cv->file_path, PATHINFO_EXTENSION);
                                    $iconClass = $ext === 'pdf' ? 'bi-file-pdf text-danger' : 'bi-file-word text-primary';
                                @endphp
                                <i class="bi {{ $iconClass }} me-1"></i> {{ $cv->name }}
                            </td>
                            <td>{{ $cv->version ?: '-' }}</td>
                            <td class="text-truncate" style="max-width: 200px;">{{ $cv->description ?: '-' }}</td>
                            <td>
                                @if($cv->is_default)
                                    <span class="badge bg-success">Default</span>
                                @else
                                    <form action="{{ route('cvs.set-default', $cv) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-light border" title="Jadikan Default">Set Default</button>
                                    </form>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $cv->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('cvs.download', $cv) }}" class="btn btn-sm btn-outline-primary" title="Download">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <a href="{{ route('cvs.edit', $cv) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('cvs.destroy', $cv) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus CV ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada CV yang diunggah. <br>
                                <a href="{{ route('cvs.create') }}" class="text-decoration-none">Mulai unggah CV Anda sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($cvs->hasPages())
        <div class="card-footer border-top-0 bg-white">
            {{ $cvs->links() }}
        </div>
    @endif
</div>
@endsection
