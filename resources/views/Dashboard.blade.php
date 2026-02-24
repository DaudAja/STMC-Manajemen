@extends('layouts.Master')

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">

        {{-- 1. Header Welcome (Tema Hijau STMC) --}}
        <div class="row mb-4">
            <div class="col-12 text-dark">
                <div class="card p-4 border-0 shadow-sm"
                    style="background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%); border-radius: 20px; border-left: 6px solid var(--stmc-primary, #10b981) !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-bold mb-1" style="color: var(--stmc-dark, #111827)">Selamat Datang di STMC Digital</h3>
                            <p class="mb-0 text-muted">Halo, <strong class="text-success">{{ auth()->user()->nama_lengkap }}</strong>. Berikut adalah ringkasan aktivitas persuratan hari ini.</p>
                        </div>
                        {{-- Jam Digital --}}
                        <div class="text-end d-none d-md-block">
                             <div id="clock" class="fw-bold" style="font-size: 2.2rem; line-height: 1; color: var(--stmc-primary, #10b981);">00:00:00</div>
                             <small class="text-muted fw-medium">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Row Kartu Statistik Utama (5 Kolom) --}}
        <style>
            /* Custom CSS untuk membuat 5 kolom rata di Desktop */
            @media (min-width: 992px) {
                .col-lg-1-5 {
                    flex: 0 0 auto;
                    width: 20%;
                }
            }
        </style>

        <div class="row mb-4 g-3">
            {{-- KARTU BARU: Total Keseluruhan --}}
            <div class="col-md-4 col-lg-1-5">
                <div class="card p-3 border-0 shadow-sm h-100" style="border-radius: 16px; background: linear-gradient(135deg, var(--stmc-primary) 0%, var(--stmc-primary-dark) 100%); color: white;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-white bg-opacity-25 rounded-circle me-3 d-flex justify-content-center align-items-center shadow-sm" style="width: 55px; height: 55px;">
                            <i class="bi bi-archive-fill text-white fs-3"></i>
                        </div>
                        <div>
                            <div class="small fw-bold text-uppercase" style="letter-spacing: 0.5px; opacity: 0.9;">Total Arsip</div>
                            <h3 class="fw-bold mb-0 text-white">{{ $totalSemuaSurat ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-1-5">
                <div class="card p-3 border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-success bg-opacity-10 rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 55px; height: 55px;">
                            <i class="bi bi-envelope-arrow-down-fill text-success fs-3"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Masuk Hari Ini</div>
                            <h3 class="fw-bold mb-0 text-dark">{{ $masukHariIni }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-1-5">
                <div class="card p-3 border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-danger bg-opacity-10 rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 55px; height: 55px;">
                            <i class="bi bi-envelope-arrow-up-fill text-danger fs-3"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Keluar Hari Ini</div>
                            <h3 class="fw-bold mb-0 text-dark">{{ $keluarHariIni }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-1-5">
                <div class="card p-3 border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-warning bg-opacity-10 rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 55px; height: 55px;">
                            <i class="bi bi-building-fill text-warning fs-3"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total Internal</div>
                            <h3 class="fw-bold mb-0 text-dark">{{ $internalCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-1-5">
                <div class="card p-3 border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-info bg-opacity-10 rounded-circle me-3 d-flex justify-content-center align-items-center" style="width: 55px; height: 55px;">
                            <i class="bi bi-globe-americas text-info fs-3"></i>
                        </div>
                        <div>
                            <div class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total Eksternal</div>
                            <h3 class="fw-bold mb-0 text-dark">{{ $externalCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SISA KODE (GRAFIK, TABEL, DAN SCRIPT) SAMA PERSIS SEPERTI SEBELUMNYA --}}

        {{-- 3. Row Charts (GRAFIK STACKED) --}}
        <div class="row mb-4">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-header bg-white py-3 border-0 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded p-2 me-2">
                            <i class="bi bi-bar-chart-line-fill text-primary"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Tren Volume Surat ({{ date('Y') }})</h6>
                    </div>
                    <div class="card-body pt-0">
                        <canvas id="chartBulanan" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-header bg-white py-3 border-0 d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded p-2 me-2">
                            <i class="bi bi-pie-chart-fill text-success"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Komposisi Arsip Tahun Ini</h6>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center pt-0">
                        <canvas id="chartKomposisi" style="max-height: 250px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Tabel & Log --}}
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded p-2 me-3">
                                <i class="bi bi-inboxes-fill text-info"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Aktivitas Surat Terbaru</h6>
                                <small class="text-muted" style="font-size: 0.75rem;">Data realtime sistem</small>
                            </div>
                        </div>
                        <a href="{{ route('surat.masuk') }}" class="btn btn-sm btn-outline-success rounded-pill px-3" style="font-size: 0.8rem;">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0 border-top">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-uppercase text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                    <tr>
                                        <th class="ps-4 py-3">No. Surat</th>
                                        <th class="py-3">Perihal</th>
                                        <th class="py-3">Kategori</th>
                                        <th class="py-3">Waktu</th>
                                        <th class="text-center py-3 pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($suratTerbaru as $surat)
                                        <tr style="transition: 0.2s;">
                                            <td class="ps-4 fw-bold text-dark" style="font-size: 0.85rem;">{{ $surat->nomor_surat }}</td>
                                            <td style="font-size: 0.85rem;">{{ Str::limit($surat->nama_surat, 30) }}</td>
                                            <td>
                                                @if($surat->category->jenis == 'masuk')
                                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 shadow-sm border border-success-subtle">Masuk</span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 shadow-sm border border-danger-subtle">Keluar</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $surat->created_at->format('H:i') }}</div>
                                                <small class="text-muted" style="font-size: 0.75rem;">{{ $surat->created_at->format('d/m/Y') }}</small>
                                            </td>
                                            <td class="text-center pe-4">
                                                <a href="{{ route('surat.show', $surat->id) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm"><i class="bi bi-eye-fill"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <div class="bg-light rounded-circle d-flex justify-content-center align-items-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                                    <i class="bi bi-inbox fs-3 text-muted"></i>
                                                </div>
                                                <span class="small fw-medium">Belum ada data surat terbaru.</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-header bg-white py-3 border-0 d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded p-2 me-2">
                            <i class="bi bi-clock-history text-warning"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Log Aktivitas</h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="timeline-wrapper mt-2" style="border-left: 2px dashed #cbd5e1; margin-left: 10px; padding-left: 20px;">
                            @forelse($logs as $log)
                                <div class="mb-4 position-relative">
                                    <div class="position-absolute bg-white border border-2 border-primary rounded-circle" style="width: 12px; height: 12px; left: -27.5px; top: 4px;"></div>

                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-bold text-dark" style="font-size: 0.85rem;">
                                            {{ $log->user->nama_lengkap ?? 'System' }}
                                        </span>
                                        <small class="text-muted" style="font-size: 0.7rem;">{{ $log->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0 text-muted" style="font-size: 0.8rem; line-height: 1.4;">{{ $log->deskripsi }}</p>
                                </div>
                            @empty
                                <p class="text-center text-muted small py-4">Belum ada aktivitas tercatat.</p>
                            @endforelse
                        </div>
                         @if(Auth::user()->role === 'admin')
                            <div class="mt-4 text-center border-top pt-3">
                                <a href="{{ route('admin.logs') }}" class="text-success text-decoration-none fw-bold small">Lihat Semua Log <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                         @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function updateClock() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            const el = document.getElementById('clock');
            if (el) el.innerText = h + ":" + m + ":" + s;
        }
        setInterval(updateClock, 1000);
        updateClock();

        document.addEventListener("DOMContentLoaded", function() {
            const ctxBar = document.getElementById('chartBulanan');
            if(ctxBar) {
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [
                            {
                                label: 'Surat Masuk',
                                data: {!! json_encode(array_values($masukBulanan ?? array_fill(0, 12, 0))) !!},
                                backgroundColor: '#10b981',
                                borderRadius: 4
                            },
                            {
                                label: 'Surat Keluar',
                                data: {!! json_encode(array_values($keluarBulanan ?? array_fill(0, 12, 0))) !!},
                                backgroundColor: '#ef4444',
                                borderRadius: 4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { stacked: true, grid: { display: false } },
                            y: { stacked: true, beginAtZero: true, grid: { borderDash: [2, 4] }, ticks: { precision: 0, stepSize: 1 } }
                        },
                        plugins: {
                            legend: { display: true, position: 'top', labels: { usePointStyle: true, boxWidth: 8 } },
                            tooltip: { mode: 'index', intersect: false }
                        }
                    }
                });
            }

            const ctxPie = document.getElementById('chartKomposisi');
            if(ctxPie) {
                new Chart(ctxPie, {
                    type: 'doughnut',
                    data: {
                        labels: ['Surat Masuk', 'Surat Keluar'],
                        datasets: [{
                            data: [{{ $totalMasuk ?? 0 }}, {{ $totalKeluar ?? 0 }}],
                            backgroundColor: ['#10b981', '#ef4444'],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                        }
                    }
                });
            }
        });
    </script>
@endsection
