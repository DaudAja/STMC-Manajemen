@extends('layouts.Master')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    {{-- Bagian Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark d-flex align-items-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1);">
                    <i class="bi bi-pencil-square" style="color: var(--stmc-primary); font-size: 1.2rem;"></i>
                </div>
                Edit Data Surat
            </h4>
            <p class="text-muted ms-5 mb-0" style="font-size: 0.9rem;">Perbarui informasi arsip surat yang sudah terdaftar di sistem SIMAS STMC.</p>
        </div>
    </div>

    <div class="row">
        {{-- Menggunakan col-lg-10 agar kartu lebih lebar dan memenuhi layar --}}
        <div class="col-lg-10 mx-auto">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('surat.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- SEKSI 1: INFORMASI TETAP (READ-ONLY) --}}
                        <div class="row g-4 mb-5">
                            <div class="col-12">
                                <h6 class="text-uppercase fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 1px;">
                                    <i class="bi bi-info-circle me-2"></i>1. Informasi Arsip & Klasifikasi
                                </h6>
                                <hr class="mt-2 mb-0 opacity-25">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">Nomor Surat</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light text-primary border-light-subtle"><i class="bi bi-hash"></i></span>
                                    <input type="text"
                                        class="form-control form-control-lg {{ $surat->category->jenis == 'keluar' ? 'bg-light text-muted' : 'bg-white' }} fw-bold border-light-subtle @error('nomor_surat') is-invalid @enderror"
                                        id="nomor_surat" name="nomor_surat"
                                        value="{{ old('nomor_surat', $surat->nomor_surat) }}"
                                        {{ $surat->category->jenis == 'keluar' ? 'readonly' : '' }}>
                                </div>

                                @if ($surat->category->jenis == 'keluar')
                                    <small class="text-danger mt-2 d-block" style="font-size: 0.75rem;">
                                        <i class="bi bi-lock-fill"></i> Nomor surat keluar digenerate otomatis dan tidak dapat diubah.
                                    </small>
                                @else
                                    <small class="text-success mt-2 d-block" style="font-size: 0.75rem;">
                                        <i class="bi bi-pencil-fill"></i> Anda dapat menyesuaikan nomor untuk arsip surat masuk.
                                    </small>
                                @endif

                                @error('nomor_surat')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark">Kategori / Sifat</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light text-muted border-light-subtle"><i class="bi bi-tag"></i></span>
                                    <input type="text" class="form-control form-control-lg bg-light text-muted border-light-subtle"
                                        value="{{ $surat->category->nama_kategori }} ({{ ucfirst($surat->category->sifat) }})" readonly>
                                </div>
                                <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">* Kategori tidak dapat diubah setelah surat diarsipkan.</small>
                            </div>
                        </div>

                        {{-- SEKSI 2: DETAIL DATA YANG BISA DIEDIT --}}
                        <div class="row g-4">
                            <div class="col-12">
                                <h6 class="text-uppercase fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 1px;">
                                    <i class="bi bi-pencil-square me-2"></i>2. Detail Perubahan
                                </h6>
                                <hr class="mt-2 mb-0 opacity-25">
                            </div>

                            <div class="col-md-12">
                                <label for="nama_surat" class="form-label fw-bold small text-dark">Judul / Perihal Surat</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-card-text text-muted"></i></span>
                                    <input type="text" class="form-control form-control-lg border-light-subtle @error('nama_surat') is-invalid @enderror"
                                        id="nama_surat" name="nama_surat" value="{{ old('nama_surat', $surat->nama_surat) }}">
                                </div>
                                @error('nama_surat')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_surat" class="form-label fw-bold small text-dark">Tanggal Surat</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-calendar-event text-muted"></i></span>
                                    <input type="date" class="form-control form-control-lg border-light-subtle @error('tanggal_surat') is-invalid @enderror"
                                        id="tanggal_surat" name="tanggal_surat"
                                        value="{{ old('tanggal_surat', $surat->tanggal_surat) }}">
                                </div>
                                @error('tanggal_surat')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="foto_bukti" class="form-label fw-bold small text-dark">Ganti File Dokumen (PDF)</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-file-earmark-pdf text-danger"></i></span>
                                    <input type="file" class="form-control form-control-lg border-light-subtle" id="foto_bukti" name="foto_bukti"
                                        accept="application/pdf">
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-muted" style="font-size: 0.75rem;">Biarkan kosong jika tidak ingin mengubah file.</small>
                                    <small class="text-primary fw-medium" style="font-size: 0.75rem;">File saat ini: {{ Str::limit($surat->foto_bukti, 25) }}</small>
                                </div>
                            </div>
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="row mt-5">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <a href="{{ route('surat.masuk') }}" class="btn btn-light px-4 text-muted border border-light-subtle rounded-pill">
                                    <i class="bi bi-arrow-left me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm d-flex align-items-center" style="background-color: var(--stmc-primary); border: none;">
                                    <i class="bi bi-check-circle-fill me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
