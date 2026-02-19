@extends('layouts.Master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            {{-- Kartu Form Filter --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- Header Kartu --}}
                <div class="card-header bg-primary text-white text-center p-4">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-printer-fill me-2"></i>Cetak Laporan Arsip
                    </h4>
                    <p class="mb-0 opacity-75 small">Silakan pilih periode dan jenis surat</p>
                </div>

                <div class="card-body p-4">
                    {{-- Form mengarah ke Route 'laporan.cetak' --}}
                    {{-- target="_blank" agar hasil cetak terbuka di tab baru --}}
                    <form action="{{ route('laporan.cetak') }}" method="POST" target="_blank">
                        @csrf

                        {{-- Baris Input Tanggal --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="tgl_awal" class="form-label fw-bold text-secondary">Dari Tanggal</label>
                                <input type="date"
                                       class="form-control @error('tgl_awal') is-invalid @enderror"
                                       id="tgl_awal"
                                       name="tgl_awal"
                                       value="{{ old('tgl_awal', date('Y-m-01')) }}"
                                       required>
                                @error('tgl_awal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tgl_akhir" class="form-label fw-bold text-secondary">Sampai Tanggal</label>
                                <input type="date"
                                       class="form-control @error('tgl_akhir') is-invalid @enderror"
                                       id="tgl_akhir"
                                       name="tgl_akhir"
                                       value="{{ old('tgl_akhir', date('Y-m-d')) }}"
                                       required>
                                @error('tgl_akhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Pilihan Jenis Surat --}}
                        <div class="mb-4">
                            <label for="jenis_surat" class="form-label fw-bold text-secondary">Jenis Laporan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-funnel"></i></span>
                                <select class="form-select" name="jenis_surat" id="jenis_surat">
                                    <option value="semua">Semua Surat (Masuk & Keluar)</option>
                                    <option value="masuk">Hanya Surat Masuk</option>
                                    <option value="keluar">Hanya Surat Keluar</option>
                                </select>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                                <i class="bi bi-file-earmark-pdf-fill me-2"></i>Proses & Cetak Laporan
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill text-muted">
                                Batal / Kembali
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            {{-- Info Tambahan --}}
            <div class="text-center mt-4 text-muted small">
                <i class="bi bi-info-circle me-1"></i>
                Laporan akan digenerate dalam format Siap Cetak (Print Friendly).
                <br>Pastikan Pop-up Blocker dimatikan.
            </div>

        </div>
    </div>
</div>
@endsection
