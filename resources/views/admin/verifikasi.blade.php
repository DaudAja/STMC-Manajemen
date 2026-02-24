@extends('layouts.Master')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    {{-- Bagian Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark d-flex align-items-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1);">
                    <i class="bi bi-person-lines-fill" style="color: var(--stmc-primary); font-size: 1.2rem;"></i>
                </div>
                Verifikasi Pengguna Baru
            </h4>
            <p class="text-muted ms-5 mb-0" style="font-size: 0.9rem;">Kelola dan setujui pendaftaran pengguna untuk mengakses sistem SIMAS STMC.</p>
        </div>
    </div>

    {{-- Kartu Tabel --}}
    <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8fafc;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-secondary fw-bold" style="width: 5%; font-size: 0.75rem; letter-spacing: 0.5px;">No</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Informasi User</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Kontak</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Role</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold text-center pe-4" style="font-size: 0.75rem; letter-spacing: 0.5px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr style="transition: all 0.2s ease;">
                            <td class="ps-4 text-muted fw-medium">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-3 text-primary fw-bold" style="width: 35px; height: 35px; font-size: 0.9rem;">
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
                                <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-info' }} bg-opacity-10 text-{{ $user->role == 'admin' ? 'danger' : 'info' }} px-3 py-2 rounded-pill border border-{{ $user->role == 'admin' ? 'danger' : 'info' }}-subtle shadow-sm" style="font-size: 0.75rem;">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Setujui --}}
                                    <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm d-flex align-items-center" style="transition: 0.3s; background-color: var(--stmc-primary); border: none;">
                                            <i class="bi bi-check-circle me-1"></i> Setujui
                                        </button>
                                    </form>

                                    {{-- Tombol Tolak (Dengan Konfirmasi) --}}
                                    <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK dan MENGHAPUS pendaftaran {{ $user->nama_lengkap }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 d-flex align-items-center" style="transition: 0.3s;">
                                            <i class="bi bi-x-circle me-1"></i> Tolak
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
                                        <i class="bi bi-person-check fs-1 text-muted"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark">Tidak Ada Antrean</h6>
                                    <p class="text-muted small mb-0">Semua pendaftaran pengguna telah diverifikasi.</p>
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
