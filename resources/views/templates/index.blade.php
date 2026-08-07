@extends('layouts.app')
@section('title', 'Template Surat')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Template Surat Lamaran</h1>
    <a href="{{ route('templates.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Buat Template Baru
    </a>
</div>

<div class="card">
    <div class="card-header fw-semibold">
        <i class="bi bi-file-earmark-richtext me-2 text-primary"></i> Daftar Template Anda
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 25%">Nama Template</th>
                        <th style="width: 50%">Deskripsi</th>
                        <th style="width: 25%" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($templates as $t)
                        <tr>
                            <td>
                                <span class="fw-semibold text-dark">{{ $t->name }}</span>
                            </td>
                            <td class="text-muted small">
                                {{ $t->description ?: 'Tidak ada deskripsi.' }}
                            </td>
                            <td class="text-end">
                                <a href="{{ route('templates.edit', $t->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <form action="{{ route('templates.destroy', $t->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="bi bi-file-earmark-break fs-1 d-block mb-3 text-secondary"></i>
                                Belum ada template surat. Klik tombol di kanan atas untuk membuat template pertama Anda!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($templates->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $templates->links() }}
        </div>
    @endif
</div>

@endsection
