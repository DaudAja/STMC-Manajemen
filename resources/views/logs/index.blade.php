@extends('layouts.Master')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    {{-- Bagian Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark d-flex align-items-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1);">
                    <i class="bi bi-card-text" style="color: var(--stmc-primary); font-size: 1.2rem;"></i>
                </div>
                Log Aktivitas Sistem
            </h4>
            <p class="text-muted ms-5 mb-0" style="font-size: 0.9rem;">Pantau riwayat aktivitas seluruh pengguna di dalam sistem SIMAS STMC.</p>
        </div>
    </div>

    {{-- Kartu Tabel --}}
    <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8fafc;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px; width: 15%;">Waktu</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px; width: 20%;">Pengguna</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px; width: 15%;">Aksi</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px; width: 35%;">Detail Aktivitas</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold pe-4 text-center" style="font-size: 0.75rem; letter-spacing: 0.5px; width: 15%;">IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr style="transition: all 0.2s ease;">
                                <td class="ps-4">
                                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $log->created_at->format('d M Y') }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-clock me-1"></i>{{ $log->created_at->format('H:i:s') }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{-- Inisial Nama --}}
                                        <div class="rounded-circle d-flex justify-content-center align-items-center me-2 fw-bold text-secondary bg-light" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                            {{ strtoupper(substr($log->user->nama_lengkap ?? 'S', 0, 1)) }}
                                        </div>
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $log->user->nama_lengkap ?? 'System' }}</div>
                                    </div>
                                </td>
                                <td>
                                    {{-- Logika Warna Badge berdasarkan kolom Aksi --}}
                                    @php
                                        $badgeColor = 'bg-secondary text-secondary';
                                        $icon = 'bi-circle-fill';

                                        if (stripos($log->aksi, 'Tambah') !== false || stripos($log->aksi, 'Create') !== false) {
                                            $badgeColor = 'bg-success text-success';
                                            $icon = 'bi-plus-circle-fill';
                                        } elseif (stripos($log->aksi, 'Edit') !== false || stripos($log->aksi, 'Update') !== false) {
                                            $badgeColor = 'bg-primary text-primary';
                                            $icon = 'bi-pencil-fill';
                                        } elseif (stripos($log->aksi, 'Hapus') !== false || stripos($log->aksi, 'Delete') !== false) {
                                            $badgeColor = 'bg-danger text-danger';
                                            $icon = 'bi-trash-fill';
                                        } elseif (stripos($log->aksi, 'Login') !== false) {
                                            $badgeColor = 'bg-info text-info';
                                            $icon = 'bi-box-arrow-in-right';
                                        } elseif (stripos($log->aksi, 'Logout') !== false) {
                                            $badgeColor = 'bg-warning text-warning';
                                            $icon = 'bi-box-arrow-right';
                                        } elseif (stripos($log->aksi, 'Download') !== false) {
                                            $badgeColor = 'bg-dark text-dark';
                                            $icon = 'bi-download';
                                        }
                                    @endphp

                                    <span class="badge {{ $badgeColor }} bg-opacity-10 px-3 py-2 rounded-pill border shadow-sm d-inline-flex align-items-center" style="font-size: 0.7rem;">
                                        <i class="bi {{ $icon }} me-1"></i> {{ strtoupper($log->aksi) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted" style="font-size: 0.85rem;">{{ $log->deskripsi }}</span>
                                </td>
                                <td class="pe-4 text-center">
                                    <span class="badge bg-light text-secondary border font-monospace px-2 py-1 shadow-sm">
                                        {{ $log->ip_address ?? '127.0.0.1' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center opacity-75">
                                        <div class="bg-light rounded-circle d-flex justify-content-center align-items-center mb-3" style="width: 80px; height: 80px;">
                                            <i class="bi bi-clock-history fs-1 text-muted"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Tidak Ada Log</h6>
                                        <p class="text-muted small mb-0">Belum ada aktivitas yang terekam di sistem.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($logs->hasPages())
                <div class="d-flex justify-content-center p-3 border-top bg-light">
                    {{ $logs->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
