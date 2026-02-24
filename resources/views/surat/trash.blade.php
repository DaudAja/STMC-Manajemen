@extends('layouts.Master')

@section('title', 'Tempat Sampah Surat')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    {{-- Bagian Header --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-dark d-flex align-items-center">
                    <div class="rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 40px; height: 40px; background: rgba(220, 53, 69, 0.1);">
                        <i class="bi bi-trash-fill" style="color: #dc3545; font-size: 1.2rem;"></i>
                    </div>
                    Tempat Sampah Surat
                </h4>
                <p class="text-muted ms-5 mb-0" style="font-size: 0.9rem;">Daftar surat yang telah dihapus sementara (Soft Delete). Anda dapat memulihkan atau menghapusnya permanen.</p>
            </div>
            <a href="{{ route('surat.masuk') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Kartu Tabel --}}
    <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8fafc;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">No. Surat</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Nama Surat</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Kategori</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold text-center" style="font-size: 0.75rem; letter-spacing: 0.5px;">Tanggal Dihapus</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold text-center pe-4" style="font-size: 0.75rem; letter-spacing: 0.5px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr style="transition: all 0.2s ease;">
                            <td class="ps-4 fw-bold text-dark" style="font-size: 0.9rem;">{{ $item->nomor_surat }}</td>
                            <td style="font-size: 0.9rem;">{{ $item->nama_surat }}</td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill border border-secondary-subtle" style="font-size: 0.75rem;">
                                    <i class="bi bi-tag-fill me-1"></i> {{ $item->category->nama_kategori }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $item->deleted_at->translatedFormat('d F Y') }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-clock me-1"></i>{{ $item->deleted_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Pulihkan --}}
                                    <form action="{{ route('admin.surat.restore', $item->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm d-flex align-items-center"
                                                style="transition: 0.3s; background-color: var(--stmc-primary); border: none;"
                                                onclick="return confirm('Kembalikan surat ini ke daftar aktif?')">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Pulihkan
                                        </button>
                                    </form>

                                    {{-- Tombol Hapus Permanen --}}
                                    <form action="{{ route('admin.surat.force_delete', $item->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 d-flex align-items-center"
                                                style="transition: 0.3s;"
                                                onclick="return confirm('PERINGATAN KRUSIAL: Data akan dihapus selamanya dari database. Lanjutkan?')">
                                            <i class="bi bi-trash-fill me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center opacity-75">
                                    <div class="bg-light rounded-circle d-flex justify-content-center align-items-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="bi bi-folder-x fs-1 text-muted"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark">Tempat Sampah Kosong</h6>
                                    <p class="text-muted small mb-0">Tidak ada arsip surat yang ditemukan di sini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
