@extends('layouts.app')
@section('title', 'Tambah Lamaran')
@section('breadcrumb', 'Lamaran / Tambah')

@section('content')
<div class="row justify-content-center">
<div class="col-md-8 col-lg-7">

<div class="card">
    <div class="card-header fw-semibold">
        <i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Lamaran Baru
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('jobs.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror"
                           value="{{ old('company_name') }}" placeholder="PT Contoh Indonesia" required>
                    @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Posisi <span class="text-danger">*</span></label>
                    <input type="text" name="position" class="form-control @error('position') is-invalid @enderror"
                           value="{{ old('position') }}" placeholder="Web Developer" required>
                    @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Lokasi Penempatan</label>
                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                           value="{{ old('location') }}" placeholder="Jakarta Selatan / WFO / Remote">
                    @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sumber Loker</label>
                    <input type="text" name="source" class="form-control" value="{{ old('source') }}"
                           list="sumber-list" placeholder="LinkedIn, Jobstreet...">
                    <datalist id="sumber-list">
                        <option value="LinkedIn">
                        <option value="Jobstreet">
                        <option value="Glints">
                        <option value="Instagram">
                        <option value="Kita Lulus">
                        <option value="Website Perusahaan">
                        <option value="Lainnya">
                    </datalist>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tgl Publikasi Loker</label>
                    <input type="date" name="publish_date" class="form-control" value="{{ old('publish_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tgl Melamar</label>
                    <input type="date" name="apply_date" class="form-control" value="{{ old('apply_date') }}">
                </div>

                <div class="col-12">
                    <label class="form-label">URL Loker</label>
                    <input type="url" name="job_url" class="form-control" value="{{ old('job_url') }}"
                           placeholder="https://linkedin.com/jobs/...">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        @foreach($statuses as $key => $s)
                            <option value="{{ $key }}" {{ old('status','belum_dilamar') == $key ? 'selected' : '' }}>
                                {{ $s['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control" rows="3"
                              placeholder="Catatan tambahan...">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn-modern btn-primary-modern">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('jobs.index') }}" class="btn-modern btn-outline-modern">Batal</a>
            </div>
        </form>
    </div>
</div>

</div>
</div>
@endsection