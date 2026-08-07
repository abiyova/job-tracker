@extends('layouts.app')
@section('title', 'Export Data Lamaran')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold py-3 border-bottom">
                <i class="bi bi-cloud-arrow-down me-2 text-primary"></i> Export Data Lamaran
            </div>
            <div class="card-body p-4">
                <form action="{{ route('export.download') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-medium">Status Lamaran (Opsional)</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="belum_dilamar">Belum Dilamar</option>
                                <option value="sudah_dilamar">Sudah Dilamar</option>
                                <option value="diproses">Diproses</option>
                                <option value="interview">Interview</option>
                                <option value="tes">Tes</option>
                                <option value="offering">Offering</option>
                                <option value="ditolak">Ditolak</option>
                                <option value="diterima">Diterima</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="source" class="form-label fw-medium">Sumber Loker (Opsional)</label>
                            <input type="text" name="source" id="source" class="form-control" placeholder="Contoh: LinkedIn">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Format File Output</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" id="formatXlsx" value="xlsx" checked>
                                <label class="form-check-label" for="formatXlsx">
                                    <i class="bi bi-file-excel text-success me-1"></i> Excel (.xlsx)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" id="formatCsv" value="csv">
                                <label class="form-check-label" for="formatCsv">
                                    <i class="bi bi-filetype-csv text-secondary me-1"></i> CSV (.csv)
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-download me-1"></i> Download Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
