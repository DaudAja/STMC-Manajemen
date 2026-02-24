@extends('layouts.Master')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    {{-- Bagian Header --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-dark d-flex align-items-center">
                    <div class="rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1);">
                        <i class="bi bi-file-earmark-text-fill" style="color: var(--stmc-primary); font-size: 1.2rem;"></i>
                    </div>
                    Detail Arsip Dokumen
                </h4>
                <p class="text-muted ms-5 mb-0" style="font-size: 0.9rem;">Manajemen Dokumen Digital Semen Tonasa Medical Center</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light border shadow-sm rounded-pill px-4 py-2">
                <i class="bi bi-arrow-left me-2"></i> Dashboard
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Kolom Kiri: Informasi Metadata --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="p-3 bg-success bg-opacity-10 rounded-circle d-inline-block mb-3">
                            <i class="bi bi-file-earmark-pdf-fill text-success fs-1"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">Informasi Surat</h5>
                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge {{ $surat->jenis_surat == 'masuk' ? 'bg-primary text-primary' : 'bg-danger text-danger' }} bg-opacity-10 border border-{{ $surat->jenis_surat == 'masuk' ? 'primary' : 'danger' }}-subtle rounded-pill px-3">
                                <i class="bi bi-arrow-{{ $surat->jenis_surat == 'masuk' ? 'down-left' : 'up-right' }} me-1"></i>
                                {{ ucfirst($surat->jenis_surat) }}
                            </span>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle rounded-pill px-3">
                                {{ strtoupper($surat->category->sifat) }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="mb-3">
                            <label class="text-uppercase fw-bold text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Nomor Surat</label>
                            <p class="fw-bold text-dark mb-0" style="font-size: 1rem;">{{ $surat->nomor_surat }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="text-uppercase fw-bold text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Perihal / Nama Surat</label>
                            <p class="fw-medium text-dark mb-0" style="line-height: 1.5;">{{ $surat->nama_surat }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="text-uppercase fw-bold text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Tanggal Surat</label>
                            <p class="fw-bold text-dark mb-0">
                                <i class="bi bi-calendar3 me-2 text-success"></i>
                                @php
                                    try {
                                        $tgl = \Carbon\Carbon::parse($surat->tanggal_surat);
                                        echo $tgl->translatedFormat('d F Y');
                                    } catch (\Exception $e) {
                                        echo $surat->tanggal_surat ?? '-';
                                    }
                                @endphp
                            </p>
                        </div>

                        <div class="mb-1">
                            <label class="text-uppercase fw-bold text-muted mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Kategori Arsip</label>
                            <p class="text-dark mb-0"><i class="bi bi-tag-fill me-2 text-secondary"></i>{{ $surat->category->nama_kategori }}</p>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="mb-4">
                        <label class="text-uppercase fw-bold text-muted mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Petugas Penginput</label>
                        <div class="d-flex align-items-center p-3 bg-light rounded-3 border border-light-subtle">
                            <div class="rounded-circle d-flex justify-content-center align-items-center me-3 fw-bold bg-white shadow-sm" style="width: 40px; height: 40px; color: var(--stmc-primary);">
                                {{ strtoupper(substr($surat->user->nama_lengkap ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <p class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">{{ $surat->user->nama_lengkap ?? 'Administrator' }}</p>
                                <small class="text-muted" style="font-size: 0.75rem;">
                                    <i class="bi bi-clock me-1"></i>{{ $surat->created_at?->format('d/m/Y H:i') ?? '-' }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ asset('storage/surat/' . $surat->foto_bukti) }}" target="_blank"
                            class="btn btn-outline-success rounded-pill fw-bold" style="border-color: var(--stmc-primary); color: var(--stmc-primary);">
                            <i class="bi bi-box-arrow-up-right me-2"></i> Buka di Tab Baru
                        </a>
                        <a href="{{ asset('storage/surat/' . $surat->foto_bukti) }}" download
                            class="btn btn-success rounded-pill shadow-sm fw-bold" style="background-color: var(--stmc-primary); border: none;">
                            <i class="bi bi-download me-2"></i> Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Pratinjau Dokumen --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm overflow-hidden"
                style="border-radius: 16px; height: 85vh; display: flex; flex-direction: column;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-eye-fill me-2 text-success"></i> Pratinjau Dokumen Digital
                    </h6>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-light text-muted border me-2" style="font-size: 0.65rem;">PDF RENDERER</span>
                        <small class="text-muted small">STMC Digital Scanner</small>
                    </div>
                </div>

                <div class="card-body p-0" style="flex: 1; position: relative; background-color: #525659;">
                    @if ($surat->foto_bukti)
                        <iframe src="{{ asset('storage/surat/' . $surat->foto_bukti) }}#view=FitH" width="100%"
                            height="100%" style="position: absolute; top: 0; left: 0; border: none;">
                        </iframe>
                    @else
                        <div class="h-100 d-flex flex-column align-items-center justify-content-center text-secondary bg-light">
                            <div class="bg-white p-4 rounded-circle shadow-sm mb-3">
                                <i class="bi bi-file-earmark-x display-1 text-muted opacity-25"></i>
                            </div>
                            <h5 class="fw-bold">Berkas Tidak Ditemukan</h5>
                            <p class="text-muted small">File fisik scan surat ini mungkin telah terhapus atau dipindahkan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
