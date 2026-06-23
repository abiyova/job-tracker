@extends('layouts.app')
@section('title', 'Generate Surat Lamaran')
@section('content')

<form method="POST" action="{{ route('letters.generate') }}" id="letterForm">
    @csrf
    <div class="row g-4">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 fw-semibold border-bottom">
                    <i class="bi bi-envelope-paper me-2 text-primary"></i>Buat Surat Lamaran
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Pilih Lamaran *</label>
                        <select name="job_id" class="form-select" id="jobSelect" required>
                            <option value="">— Pilih perusahaan —</option>
                            @foreach($jobs as $job)
                                <option value="{{ $job->id }}">
                                    {{ $job->company_name }} — {{ $job->position }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Pilih Template *</label>
                        <select name="template_id" class="form-select" id="templateSelect" required>
                            <option value="">— Pilih template —</option>
                            @foreach($templates as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                        @if($templates->isEmpty())
                            <small class="text-warning d-block mt-1">
                                Belum ada template. <a href="{{ route('templates.create') }}">Buat template</a>
                            </small>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Jenis Font *</label>
                        <select name="font_family" class="form-select mb-2" id="fontFamilySelect" required>
                            <option value="Times New Roman" selected>Times New Roman</option>
                            <option value="Arial">Arial</option>
                            <option value="Calibri">Calibri</option>
                            <option value="Helvetica">Helvetica</option>
                            <option value="Tahoma">Tahoma</option>
                            <option value="Verdana">Verdana</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Ukuran Font *</label>
                        <select name="font_size" class="form-select" id="fontSizeSelect" required>
                            <option value="10">10 pt</option>
                            <option value="11">11 pt</option>
                            <option value="12" selected>12 pt (Standar)</option>
                            <option value="13">13 pt</option>
                            <option value="14">14 pt</option>
                            <option value="16">16 pt</option>
                            <option value="18">18 pt</option>
                        </select>
                    </div>
                    <input type="hidden" name="format" value="docx">
                    <div class="mb-4">
                        <label class="form-label fw-medium">Spasi Baris *</label>
                        <select name="line_spacing" class="form-select mb-2" id="lineSpacingSelect" required>
                            <option value="1.0">1.0</option>
                            <option value="1.15">1.15</option>
                            <option value="1.5" selected>1.5</option>
                            <option value="2.0">2.0</option>
                            <option value="2.5">2.5</option>
                            <option value="3.0">3.0</option>
                            <option value="custom">Custom...</option>
                        </select>
                        <input type="number" step="0.1" min="1.0" max="5.0" name="custom_line_spacing" id="customLineSpacing" class="form-control" placeholder="Masukkan nilai spasi (mis. 1.0)" style="display: none;">
                    </div>
                    <div class="alert alert-info py-2" role="alert" style="font-size: 0.85rem;">
                        <i class="bi bi-info-circle me-1"></i> <strong>Penting:</strong> Setelah file diunduh, harap periksa dan sesuaikan kembali format surat (seperti spasi, margin, dan perataan) secara manual melalui Microsoft Word.
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary" onclick="previewLetter()">
                            <i class="bi bi-eye me-1"></i>Preview & Edit
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                            <i class="bi bi-download me-1"></i>Generate & Download
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 fw-semibold border-bottom d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-file-text me-2 text-primary"></i>Preview & Edit Manual</span>
                    <span class="badge bg-light text-secondary border font-monospace" id="fontBadge">Times New Roman, 12pt</span>
                </div>
                <div class="card-body d-flex flex-column p-0">
                    <div id="previewPlaceholder" class="p-5 text-center text-muted my-auto">
                        <i class="bi bi-pencil-square fs-1 d-block mb-3 text-secondary"></i>
                        Pilih lamaran dan template, lalu klik tombol <strong>Preview & Edit</strong> untuk memuat dan melakukan perubahan manual sebelum diunduh.
                    </div>
                    <textarea name="edited_content" id="previewContent" class="form-control border-0 p-4 flex-grow-1"
                              style="font-family:'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.6; min-height: 480px; display: none; resize: vertical;"
                              placeholder="Ketik surat di sini..."></textarea>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
@push('scripts')
<script>
function updateFontPreview() {
    const family = document.getElementById('fontFamilySelect').value;
    const size = document.getElementById('fontSizeSelect').value;
    const txtArea = document.getElementById('previewContent');
    
    // Update textarea style
    txtArea.style.fontFamily = family + ', sans-serif';
    if(family === 'Times New Roman') {
        txtArea.style.fontFamily = "'Times New Roman', Times, serif";
    }
    txtArea.style.fontSize = size + 'pt';
    
    // Update badge text
    document.getElementById('fontBadge').innerText = family + ', ' + size + 'pt';
}

document.getElementById('fontSizeSelect').addEventListener('change', updateFontPreview);
document.getElementById('fontFamilySelect').addEventListener('change', updateFontPreview);

document.getElementById('lineSpacingSelect').addEventListener('change', function() {
    const customInput = document.getElementById('customLineSpacing');
    if (this.value === 'custom') {
        customInput.style.display = 'block';
        customInput.required = true;
    } else {
        customInput.style.display = 'none';
        customInput.required = false;
    }
});

function previewLetter() {
    const jobId = document.getElementById('jobSelect').value;
    const templateId = document.getElementById('templateSelect').value;
    if (!jobId || !templateId) {
        alert('Pilih lamaran dan template terlebih dahulu!');
        return;
    }

    const placeholder = document.getElementById('previewPlaceholder');
    const txtArea = document.getElementById('previewContent');

    placeholder.innerHTML = '<p class="text-center text-muted py-5"><i class="bi bi-hourglass-split"></i> Memuat isi surat...</p>';
    placeholder.style.display = 'block';
    txtArea.style.display = 'none';

    fetch('{{ route("letters.preview") }}?job_id=' + jobId + '&template_id=' + templateId)
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => { throw new Error(data.error || 'Terjadi kesalahan') });
            }
            return response.json();
        })
        .then(data => {
            placeholder.style.display = 'none';
            txtArea.value = data.content;
            txtArea.style.display = 'block';
            
            // Set font size and family to current selection
            updateFontPreview();
        })
        .catch(err => {
            placeholder.innerHTML = `<p class="text-center text-danger py-5"><i class="bi bi-exclamation-triangle"></i> ${err.message}</p>`;
            placeholder.style.display = 'block';
            txtArea.style.display = 'none';
        });
}
</script>
@endpush