@extends('layouts.app')
@section('title', 'Edit Lamaran')
@section('breadcrumb', 'Lamaran / Edit')

@section('content')
<div class="row justify-content-center">
<div class="col-md-8 col-lg-7">

<div class="card">
    <div class="card-header fw-semibold">
        <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Lamaran
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('jobs.update', $job) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror"
                           value="{{ old('company_name', $job->company_name) }}" placeholder="PT Contoh Indonesia" required>
                    @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Posisi <span class="text-danger">*</span></label>
                    <input type="text" name="position" class="form-control @error('position') is-invalid @enderror"
                           value="{{ old('position', $job->position) }}" placeholder="Web Developer" required>
                    @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Lokasi Penempatan</label>
                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                           value="{{ old('location', $job->location) }}" placeholder="Jakarta Selatan / WFO / Remote">
                    @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sumber Loker</label>
                    <input type="text" name="source" class="form-control" value="{{ old('source', $job->source) }}"
                           list="sumber-list" placeholder="LinkedIn, Jobstreet...">
                    <datalist id="sumber-list">
                        <option value="LinkedIn">
                        <option value="Jobstreet">
                        <option value="Kalibrr">
                        <option value="Glints">
                        <option value="Karir.com">
                        <option value="Referral">
                        <option value="Website Perusahaan">
                    </datalist>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tgl Publikasi Loker</label>
                    <input type="date" name="publish_date" class="form-control" value="{{ old('publish_date', optional($job->publish_date)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tgl Melamar</label>
                    <input type="date" name="apply_date" class="form-control" value="{{ old('apply_date', optional($job->apply_date)->format('Y-m-d')) }}">
                </div>

                <div class="col-12">
                    <label class="form-label">URL Loker</label>
                    <input type="url" name="job_url" class="form-control" value="{{ old('job_url', $job->job_url) }}"
                           placeholder="https://linkedin.com/jobs/...">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        @foreach($statuses as $key => $s)
                            <option value="{{ $key }}" {{ old('status', $job->status) == $key ? 'selected' : '' }}>
                                {{ $s['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control" rows="3"
                              placeholder="Catatan tambahan...">{{ old('notes', $job->notes) }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn-modern btn-primary-modern">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('jobs.index') }}" class="btn-modern btn-outline-modern">Batal</a>
            </div>
        </form>
    </div>
</div>

</div>
</div>
@endsection
