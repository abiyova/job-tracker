@extends('layouts.app')
@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header fw-semibold">Editor Template Surat</div>
            <div class="card-body">
                <form method="POST" action="{{ route('templates.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Template *</label>
                        <input type="text" name="name" class="form-control" required
                               placeholder="Formal, Fresh Graduate, IT Support...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" name="description" class="form-control"
                               placeholder="Deskripsi singkat penggunaan template ini...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi Surat</label>
                        <textarea name="content" class="form-control font-monospace"
                                  rows="20" style="font-size:.85rem"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Simpan Template
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card sticky-top" style="top:80px">
            <div class="card-header fw-semibold text-muted small">
                <i class="bi bi-braces me-1"></i>Placeholder Tersedia
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush" style="max-height: 500px; overflow-y: auto;">
                    @foreach([
                        '[Tanggal Hari Ini]' => 'Waktu cetak surat',
                        '[Nama Perusahaan]'  => 'Sesuai data lamaran',
                        '[Posisi Pekerjaan]' => 'Sesuai data lamaran',
                        '[Sumber Info]'      => 'Sesuai data lamaran',
                        '[Nama Lengkap]'     => 'Dari profil Anda',
                        '[No Telepon]'       => 'Dari profil Anda',
                        '[Email]'            => 'Dari profil Anda',
                        '[Alamat Lengkap]'   => 'Dari profil Anda',
                        '[Pendidikan]'       => 'Dari profil Anda',
                        '[Link Portofolio]'  => 'Dari profil Anda',
                        '[Link LinkedIn]'    => 'Dari profil Anda',
                        '[Link GitHub]'      => 'Dari profil Anda',
                        '[Ringkasan]'        => 'Dari profil Anda'
                    ] as $ph => $desc)
                    <button type="button" class="list-group-item list-group-item-action py-2"
                            onclick="insertPlaceholder('{{ $ph }}')">
                        <div class="font-monospace text-primary fw-semibold small mb-1">{{ $ph }}</div>
                        <div class="text-muted" style="font-size: 0.7rem;">{{ $desc }}</div>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function insertPlaceholder(text) {
    const ta = document.querySelector('textarea[name=content]');
    const start = ta.selectionStart;
    const before = ta.value.substring(0, start);
    const after  = ta.value.substring(ta.selectionEnd);
    ta.value = before + text + after;
    ta.focus();
    ta.selectionStart = ta.selectionEnd = start + text.length;
}
</script>
@endpush