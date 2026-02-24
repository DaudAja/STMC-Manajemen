@extends('layouts.Master')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    {{-- Bagian Header --}}
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h4 class="fw-bold text-dark d-flex align-items-center justify-content-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 45px; height: 45px; background: rgba(16, 185, 129, 0.1);">
                    <i class="bi bi-printer-fill" style="color: var(--stmc-primary); font-size: 1.3rem;"></i>
                </div>
                Cetak Laporan Arsip
            </h4>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">Generate dokumen rekapitulasi surat secara otomatis berdasarkan periode tertentu.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            {{-- Kartu Form Filter --}}
            <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-white py-3 border-bottom-0 text-center mt-3">
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-4 py-2 border border-success-subtle">
                        FILTER PERIODE LAPORAN
                    </span>
                </div>

                <div class="card-body p-4 p-md-5 pt-2">
                    <form action="{{ route('laporan.cetak') }}" method="POST" target="_blank">
                        @csrf

                        {{-- Baris Input Tanggal --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="tgl_awal" class="form-label fw-bold small text-dark">Mulai Dari Tanggal</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-calendar-date text-muted"></i></span>
                                    <input type="date"
                                           class="form-control border-light-subtle @error('tgl_awal') is-invalid @enderror"
                                           id="tgl_awal"
                                           name="tgl_awal"
                                           value="{{ old('tgl_awal', date('Y-m-01')) }}"
                                           required>
                                </div>
                                @error('tgl_awal')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tgl_akhir" class="form-label fw-bold small text-dark">Sampai Tanggal</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-calendar-check text-muted"></i></span>
                                    <input type="date"
                                           class="form-control border-light-subtle @error('tgl_akhir') is-invalid @enderror"
                                           id="tgl_akhir"
                                           name="tgl_akhir"
                                           value="{{ old('tgl_akhir', date('Y-m-d')) }}"
                                           required>
                                </div>
                                @error('tgl_akhir')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Pilihan Jenis Surat --}}
                        <div class="mb-5">
                            <label for="jenis_surat" class="form-label fw-bold small text-dark">Jenis Arus Laporan</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-funnel-fill text-success"></i></span>
                                <select class="form-select border-light-subtle" name="jenis_surat" id="jenis_surat">
                                    <option value="semua">Semua Surat (Masuk & Keluar)</option>
                                    <option value="masuk">Hanya Surat Masuk</option>
                                    <option value="keluar">Hanya Surat Keluar</option>
                                </select>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm py-3 d-flex align-items-center justify-content-center" style="background-color: var(--stmc-primary); border: none; transition: 0.3s;">
                                <i class="bi bi-file-earmark-pdf-fill me-2 fs-5"></i> Proses & Cetak PDF
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill py-2 text-muted border border-light-subtle mt-2">
                                <i class="bi bi-x-lg me-1 small"></i> Batal / Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info Tambahan --}}
            <div class="text-center mt-4 p-3 bg-light rounded-4 border border-white shadow-sm animate__animated animate__fadeInUp animate__delay-1s">
                <div class="text-muted" style="font-size: 0.75rem; line-height: 1.6;">
                    <i class="bi bi-info-circle-fill text-primary me-1"></i>
                    <strong>Catatan Sistem:</strong> Laporan akan dihasilkan dalam format PDF siap cetak.
                    Pastikan peramban Anda mengizinkan jendela munculan (*pop-up*) untuk melihat hasil cetakan secara langsung.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
