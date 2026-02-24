@extends('layouts.Master')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    {{-- Bagian Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark d-flex align-items-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 40px; height: 40px; background: rgba(220, 53, 69, 0.1);">
                    <i class="bi bi-trash3-fill" style="color: #dc3545; font-size: 1.2rem;"></i>
                </div>
                Arsip User (Ditolak/Dihapus)
            </h4>
            <p class="text-muted ms-5 mb-0" style="font-size: 0.9rem;">Daftar pengguna yang ditolak pendaftarannya atau dihapus aksesnya dari sistem.</p>
        </div>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 animate__animated animate__fadeInDown" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-3 fs-4 text-success"></i>
                <div>
                    <h6 class="mb-0 fw-bold">Berhasil!</h6>
                    <small>{{ session('success') }}</small>
                </div>
            </div>
            <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Kartu Tabel --}}
    <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8fafc;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-secondary fw-bold" style="width: 5%; font-size: 0.75rem; letter-spacing: 0.5px;">No</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Nama & Email</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">No. Telepon</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Tanggal Dihapus</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold text-center pe-4" style="font-size: 0.75rem; letter-spacing: 0.5px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr style="transition: all 0.2s ease;">
                            <td class="ps-4 text-muted fw-medium">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{-- Inisial Nama sebagai Avatar --}}
                                    <div class="rounded-circle d-flex justify-content-center align-items-center me-3 fw-bold shadow-sm border" style="width: 40px; height: 40px; background: #f1f5f9; color: #64748b; font-size: 1rem;">
                                        {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $user->nama_lengkap }}</div>
                                        <div class="text-muted" style="font-size: 0.8rem;"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border font-monospace px-2 py-1">
                                    <i class="bi bi-telephone text-secondary me-1"></i>{{ $user->no_telepon }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $user->deleted_at->format('d M Y') }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-clock me-1"></i>{{ $user->deleted_at->format('H:i') }}</div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Restore --}}
                                    <form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm d-flex align-items-center" style="transition: 0.3s; background-color: var(--stmc-primary); border: none;">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Restore
                                        </button>
                                    </form>

                                    {{-- Tombol Hapus Permanen --}}
                                    <form action="{{ route('admin.users.force_delete', $user->id) }}" method="POST" onsubmit="return confirm('Sangat Penting: Apakah Anda yakin ingin menghapus user ini secara PERMANEN? Data tidak dapat dipulihkan kembali!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 d-flex align-items-center" style="transition: 0.3s;">
                                            <i class="bi bi-trash-fill me-1"></i> Hapus Permanen
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
                                        <i class="bi bi-trash fs-1 text-muted"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark">Tempat Sampah Kosong</h6>
                                    <p class="text-muted small mb-0">Tidak ada data pengguna yang baru saja dihapus.</p>
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
