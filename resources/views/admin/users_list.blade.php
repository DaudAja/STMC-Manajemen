@extends('layouts.Master')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    {{-- Bagian Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark d-flex align-items-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1);">
                    <i class="bi bi-person-gear" style="color: var(--stmc-primary); font-size: 1.2rem;"></i>
                </div>
                Manajemen Pengguna
            </h4>
            <p class="text-muted ms-5 mb-0" style="font-size: 0.9rem;">Pantau pengguna aktif dan kelola hak akses mereka ke sistem STMC.</p>
        </div>
    </div>

    {{-- Alert Notifikasi (Diperbarui lebih modern) --}}
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
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Profil Pengguna</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Kontak</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Status</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold text-center pe-4" style="font-size: 0.75rem; letter-spacing: 0.5px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr style="transition: all 0.2s ease;">
                            <td class="ps-4 text-muted fw-medium">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{-- Menggunakan Inisial Nama sebagai Avatar --}}
                                    <div class="rounded-circle d-flex justify-content-center align-items-center me-3 fw-bold shadow-sm border border-success-subtle" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1); color: var(--stmc-primary); font-size: 1.1rem;">
                                        {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $user->nama_lengkap }}</div>
                                        <div class="text-muted" style="font-size: 0.8rem;"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border font-monospace px-2 py-1 shadow-sm">
                                    <i class="bi bi-telephone text-success me-1"></i>{{ $user->no_telepon }}
                                </span>
                            </td>
                            <td>
                                @if($user->status == 'active')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill border border-success-subtle shadow-sm" style="font-size: 0.75rem;">
                                        <i class="bi bi-patch-check-fill me-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill border border-danger-subtle shadow-sm" style="font-size: 0.75rem;">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol untuk User Aktif --}}
                                    @if($user->status == 'active')
                                        <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENONAKTIFKAN akses untuk {{ $user->nama_lengkap }}?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 d-flex align-items-center" style="transition: 0.3s;">
                                                <i class="bi bi-person-x me-1"></i> Nonaktifkan
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol untuk User Nonaktif --}}
                                    @if($user->status == 'inactive')
                                        <form action="{{ route('admin.users.activate', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm d-flex align-items-center" style="transition: 0.3s; background-color: var(--stmc-primary); border: none;">
                                                <i class="bi bi-person-check me-1"></i> Aktifkan Kembali
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Opsi Hapus Permanen (Komentar tidak diubah) --}}
                                    {{-- <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-muted p-0 ms-2" title="Hapus Akun">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center opacity-75">
                                    <div class="bg-light rounded-circle d-flex justify-content-center align-items-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="bi bi-people fs-1 text-muted"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark">Tidak Ada Data</h6>
                                    <p class="text-muted small mb-0">Belum ada pengguna yang terdaftar di sistem.</p>
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
