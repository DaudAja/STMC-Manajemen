@extends('layouts.Master')

@section('content')
{{-- container-fluid p-0 memastikan tampilan penuh hingga tepi layar --}}
<div class="container-fluid p-0 animate__animated animate__fadeIn">
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="card border-0 shadow-none" style="min-height: 100vh; border-radius: 0;">

                {{-- Header Full Width --}}
                <div class="card-header bg-white py-4 px-4 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-file-earmark-plus me-2 text-primary"></i> Input Arsip Surat Baru
                    </h5>
                    <p class="text-muted small mb-0 mt-1">Gunakan formulir ini untuk mengarsipkan surat Internal maupun External secara sistematis.</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-2">

                            {{-- 1. Pilihan Sifat Surat --}}
                            <div class="col-md-4">
                                <label class="form-label fw-bold">1. Sifat Surat</label>
                                <select id="sifat_surat" name="sifat_surat" class="form-select form-select-lg shadow-sm" required>
                                    <option value="external">Eksternal</option>
                                    <option value="internal">Internal</option>
                                </select>
                            </div>

                            {{-- 2. Pilihan Jenis Arus --}}
                            <div class="col-md-4">
                                <label class="form-label fw-bold">2. Jenis Arus Surat</label>
                                <select id="jenis_surat" name="jenis_surat" class="form-select form-select-lg shadow-sm" required>
                                    <option value="keluar">Surat Keluar</option>
                                    <option value="masuk">Surat Masuk</option>
                                </select>
                            </div>

                            {{-- 3. Kategori (Dinamis berdasarkan Sifat & Jenis) --}}
                            <div class="col-md-4">
                                <label class="form-label fw-bold">3. Kategori / Klasifikasi</label>
                                <select id="category_id" name="category_id" class="form-select form-select-lg shadow-sm" required>
                                    <option value="">-- Pilih Kategori --</option>
                                </select>
                            </div>

                            {{-- Nomor Surat Otomatis / Manual --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Nomor Surat</label>
                                <div class="input-group input-group-sm shadow-sm">
                                    <span class="input-group-text bg-light text-primary"><i class="bi bi-hash"></i></span>
                                    <input type="text" id="nomor_surat_display" name="nomor_surat" class="form-control bg-light fw-bold" placeholder="Pilih kategori untuk melihat nomor..." required readonly>
                                </div>
                                <small class="text-muted mt-2 d-block">* Khusus Surat Masuk, nomor dapat diketik manual setelah memilih kategori.</small>
                            </div>

                            {{-- Perihal --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Perihal / Isi Ringkas Surat</label>
                                <input type="text" name="nama_surat" class="form-control form-control-lg shadow-sm" placeholder="Contoh: Permohonan Kerjasama Vendor atau Nota Dinas Rapat" required>
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary">Tanggal Surat</label>
                                <input type="date" name="tanggal_surat" class="form-control form-control-lg shadow-sm" value="{{ date('Y-m-d') }}" required>
                            </div>

                            {{-- Upload PDF --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary">Dokumen Scan (PDF)</label>
                                <input type="file" name="foto_bukti" id="file_pdf" class="form-control form-control-lg shadow-sm" accept=".pdf" required>
                                <small class="text-muted">Pastikan format file PDF (Maks. 5MB)</small>
                            </div>

                            {{-- Alert File Terpilih --}}
                            <div class="col-12 d-none" id="pdf-alert">
                                <div class="alert alert-success d-flex align-items-center shadow-sm">
                                    <i class="bi bi-file-earmark-check-fill me-2 fs-4"></i>
                                    <div>
                                        <span id="pdf-name" class="fw-bold">File terpilih.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <a href="/dashboard" class="btn btn-light btn-lg px-4 text-muted border">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
                                <i class="bi bi-cloud-arrow-up me-2"></i> Simpan Arsip Surat
                            </button>
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
            // Memanggil Route dengan 2 parameter: /get-categories/{sifat}/{jenis}
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

    // Jalankan filter saat halaman pertama dibuka
    fetchCategories();

    // Jalankan filter saat Sifat atau Jenis diubah
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

            // Logika: Jika sistem memberikan string 'MANUAL' (untuk surat masuk), buka inputnya
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
