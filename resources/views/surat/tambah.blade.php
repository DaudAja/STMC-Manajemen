@extends('layouts.Master')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    {{-- Bagian Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark d-flex align-items-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1);">
                    <i class="bi bi-file-earmark-plus" style="color: var(--stmc-primary); font-size: 1.2rem;"></i>
                </div>
                Input Arsip Surat Baru
            </h4>
            <p class="text-muted ms-5 mb-0" style="font-size: 0.9rem;">Gunakan formulir ini untuk mengarsipkan surat Internal maupun External secara sistematis.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- SEKSI 1: KLASIFIKASI --}}
                        <div class="row g-4 mb-4">
                            <div class="col-12">
                                <h6 class="text-uppercase fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 1px;">
                                    <i class="bi bi-tags me-2"></i>1. Klasifikasi Surat
                                </h6>
                                <hr class="mt-2 mb-0 opacity-25">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-dark">Sifat Surat</label>
                                <select id="sifat_surat" name="sifat_surat" class="form-select form-select-lg shadow-sm border-light-subtle" required>
                                    <option value="external">Eksternal</option>
                                    <option value="internal">Internal</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-dark">Jenis Arus Surat</label>
                                <select id="jenis_surat" name="jenis_surat" class="form-select form-select-lg shadow-sm border-light-subtle" required>
                                    <option value="keluar">Surat Keluar</option>
                                    <option value="masuk">Surat Masuk</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-dark">Kategori / Klasifikasi</label>
                                <select id="category_id" name="category_id" class="form-select form-select-lg shadow-sm border-light-subtle" required>
                                    <option value="">-- Pilih Kategori --</option>
                                </select>
                            </div>
                        </div>

                        {{-- SEKSI 2: DETAIL SURAT --}}
                        <div class="row g-4 mb-4">
                            <div class="col-12 mt-5">
                                <h6 class="text-uppercase fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 1px;">
                                    <i class="bi bi-info-circle me-2"></i>2. Informasi Detail Surat
                                </h6>
                                <hr class="mt-2 mb-0 opacity-25">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-dark">Nomor Surat</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-light text-primary border-light-subtle"><i class="bi bi-hash"></i></span>
                                    <input type="text" id="nomor_surat_display" name="nomor_surat" class="form-control form-control-lg bg-light fw-bold border-light-subtle" placeholder="Pilih kategori untuk melihat nomor..." required readonly>
                                </div>
                                <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">* Khusus Surat Masuk, nomor dapat diketik manual setelah memilih kategori.</small>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-dark">Perihal / Isi Ringkas Surat</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-card-text text-muted"></i></span>
                                    <input type="text" name="nama_surat" class="form-control form-control-lg border-light-subtle" placeholder="Contoh: Permohonan Kerjasama Vendor atau Nota Dinas Rapat" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-secondary">Tanggal Surat</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-calendar-event text-muted"></i></span>
                                    <input type="date" name="tanggal_surat" class="form-control form-control-lg border-light-subtle" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            {{-- SEKSI 3: DOKUMEN --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-secondary">Dokumen Scan (PDF)</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-file-earmark-pdf text-danger"></i></span>
                                    <input type="file" name="foto_bukti" id="file_pdf" class="form-control form-control-lg border-light-subtle" accept=".pdf" required>
                                </div>
                                <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">Format file: PDF (Maks. 5MB)</small>
                            </div>

                            {{-- Alert File Terpilih --}}
                            <div class="col-12 d-none mt-3" id="pdf-alert">
                                <div class="alert alert-success d-flex align-items-center shadow-sm border-0 mb-0">
                                    <i class="bi bi-file-earmark-check-fill me-2 fs-4"></i>
                                    <div>
                                        <span id="pdf-name" class="fw-bold small">File terpilih.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <a href="/dashboard" class="btn btn-light px-4 text-muted border border-light-subtle rounded-pill">
                                    <i class="bi bi-arrow-left me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm d-flex align-items-center" style="background-color: var(--stmc-primary); border: none;">
                                    <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan Arsip Surat
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sifatSurat = document.getElementById('sifat_surat');
    const jenisSurat = document.getElementById('jenis_surat');
    const categorySelect = document.getElementById('category_id');
    const nomorDisplay = document.getElementById('nomor_surat_display');
    const fileInput = document.getElementById('file_pdf');
    const pdfAlert = document.getElementById('pdf-alert');

    // 1. Fungsi Ambil Kategori berdasarkan Filter Sifat & Jenis
    async function fetchCategories() {
        const sifat = sifatSurat.value;
        const jenis = jenisSurat.value;

        categorySelect.innerHTML = '<option value="">-- Loading... --</option>';
        nomorDisplay.value = '';
        nomorDisplay.readOnly = true;

        try {
            const response = await fetch(`/get-categories/${sifat}/${jenis}`);
            const data = await response.json();

            categorySelect.innerHTML = '<option value="">-- Pilih Kategori --</option>';
            data.forEach(cat => {
                const opt = new Option(cat.nama_kategori, cat.id);
                categorySelect.add(opt);
            });
        } catch (error) {
            console.error('Error:', error);
            categorySelect.innerHTML = '<option value="">-- Gagal memuat data --</option>';
        }
    }

    fetchCategories();

    sifatSurat.addEventListener('change', fetchCategories);
    jenisSurat.addEventListener('change', fetchCategories);

    // 2. Fungsi Ambil Nomor Surat (Otomatis/Manual)
    categorySelect.addEventListener('change', async function() {
        const catId = this.value;
        if (!catId) return;

        nomorDisplay.value = 'Generating...';

        try {
            const response = await fetch(`/get-nomor-surat/${catId}`);
            const data = await response.json();

            if (data.nomor === 'MANUAL') {
                nomorDisplay.value = '';
                nomorDisplay.readOnly = false;
                nomorDisplay.placeholder = 'Ketik nomor surat masuk secara manual...';
                nomorDisplay.classList.remove('bg-light');
                nomorDisplay.focus();
            } else {
                nomorDisplay.value = data.nomor;
                nomorDisplay.readOnly = true;
                nomorDisplay.classList.add('bg-light');
            }
        } catch (error) {
            console.error('Error:', error);
            nomorDisplay.value = 'Gagal generate nomor';
        }
    });

    // 3. Notifikasi PDF Terpilih
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            pdfAlert.classList.remove('d-none');
            document.getElementById('pdf-name').innerText = `Dokumen: ${this.files[0].name}`;
        } else {
            pdfAlert.classList.add('d-none');
        }
    });
});
</script>
@endpush
