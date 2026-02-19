@extends('layouts.Master')

@section('title', 'Tempat Sampah Surat')

@section('content')
<div class="container-fluid">
    <div class="row animate__animated animate__fadeIn">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0 text-primary">
                            <i class="bi bi-trash-fill me-2"></i>Tempat Sampah Surat
                        </h5>
                        <small class="text-muted">Daftar surat yang telah dihapus sementara (Soft Delete)</small>
                    </div>
                    <a href="{{ route('surat.masuk') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Surat Masuk
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3">No. Surat</th>
                                    <th>Nama Surat</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Tanggal Dihapus</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                <tr>
                                    <td class="px-4 fw-bold text-dark">{{ $item->nomor_surat }}</td>
                                    <td>{{ $item->nama_surat }}</td>
                                    <td>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                            {{ $item->category->nama_kategori }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">
                                            {{ $item->deleted_at->translatedFormat('d F Y') }}<br>
                                            <span style="font-size: 10px;">{{ $item->deleted_at->format('H:i') }} WIB</span>
                                        </small>
                                    </td>
                                    <td class="text-center px-4">
                                        {{-- FORM RESTORE --}}
                                        <form action="{{ route('admin.surat.restore', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3"
                                                    onclick="return confirm('Kembalikan surat ini ke daftar aktif?')">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i> Pulihkan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <img src="https://illustrations.popsy.co/gray/empty-folder.svg" alt="Kosong" width="150" class="mb-3">
                                        <p class="text-muted mb-0">Tidak ada surat di tempat sampah.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
