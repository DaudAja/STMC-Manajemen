@extends('layouts.Master')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-primary text-white p-4 rounded-top-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Data Surat</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('surat.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- PENTING: Method PUT untuk update --}}

                        {{-- Info Read-Only (Tidak bisa diedit user biasa demi keamanan nomor urut) --}}
                        <div class="alert alert-light border mb-4">
                            <small class="text-muted d-block text-uppercase fw-bold mb-2">Informasi Tetap</small>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-secondary small">Nomor Surat</label>
                                    <input type="text" class="form-control bg-light" value="{{ $surat->nomor_surat }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-secondary small">Kategori</label>
                                    <input type="text" class="form-control bg-light" value="{{ $surat->category->nama_kategori }}" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Form Edit --}}
                        <div class="mb-3">
                            <label for="nama_surat" class="form-label fw-semibold">Judul / Perihal Surat</label>
                            <input type="text" class="form-control @error('nama_surat') is-invalid @enderror"
                                   id="nama_surat" name="nama_surat" value="{{ old('nama_surat', $surat->nama_surat) }}">
                            @error('nama_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_surat" class="form-label fw-semibold">Tanggal Surat</label>
                            <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror"
                                   id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', $surat->tanggal_surat) }}">
                        </div>

                        <div class="mb-4">
                            <label for="foto_bukti" class="form-label fw-semibold">Ganti File Dokumen (Opsional)</label>
                            <input type="file" class="form-control" id="foto_bukti" name="foto_bukti" accept="application/pdf">
                            <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file PDF saat ini.</div>
                            <div class="mt-2 small text-primary">File saat ini: {{ $surat->foto_bukti }}</div>
                        </div>

                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="{{ route('surat.show', $surat->id) }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
