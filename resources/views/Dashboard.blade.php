@extends('layouts.Master')

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">

        {{-- 1. Header Welcome --}}
        <div class="row mb-4">
            <div class="col-12 text-white">
                <div class="card p-4 border-0 shadow-sm text-dark"
                    style="background: var(--stmc-gradient, linear-gradient(135deg, #e3f2fd 0%, #ffffff 100%)); border-radius: 20px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1" style="color: var(--stmc-primary, #0d6efd)">Selamat Datang di STMC Digital</h2>
                            <p class="mb-0 opacity-75">Halo, <strong>{{ auth()->user()->nama_lengkap }}</strong>. Berikut ringkasan aktivitas hari ini.</p>
                        </div>
                        {{-- Jam Digital --}}
                        <div class="text-end d-none d-md-block">
                             <div id="clock" class="fw-bold text-primary" style="font-size: 2rem; line-height: 1;">00:00:00</div>
                             <small class="text-muted">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Row Kartu Statistik Utama --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card p-3 border-0 shadow-sm border-start border-primary border-4 h-100">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-primary bg-opacity-10 rounded me-3"><i class="bi bi-envelope-download text-primary fs-3"></i></div>
                        <div>
                            <div class="text-muted small fw-bold">Masuk Hari Ini</div>
                            <h4 class="fw-bold mb-0">{{ $masukHariIni }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 border-0 shadow-sm border-start border-success border-4 h-100">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-success bg-opacity-10 rounded me-3"><i class="bi bi-envelope-upload text-success fs-3"></i></div>
                        <div>
                            <div class="text-muted small fw-bold">Keluar Hari Ini</div>
                            <h4 class="fw-bold mb-0">{{ $keluarHariIni }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 border-0 shadow-sm border-start border-warning border-4 h-100">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-warning bg-opacity-10 rounded me-3"><i class="bi bi-building text-warning fs-3"></i></div>
                        <div>
                            <div class="text-muted small fw-bold">Total Internal</div>
                            <h4 class="fw-bold mb-0">{{ $internalCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 border-0 shadow-sm border-start border-info border-4 h-100">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-info bg-opacity-10 rounded me-3"><i class="bi bi-globe text-info fs-3"></i></div>
                        <div>
                            <div class="text-muted small fw-bold">Total External</div>
                            <h4 class="fw-bold mb-0">{{ $externalCount }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Row Charts (GRAFIK BARU) --}}
        <div class="row mb-4">
            {{-- Grafik Batang (Tren Bulanan) --}}
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Tren Volume Surat ({{ date('Y') }})</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartBulanan" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            {{-- Grafik Donut (Komposisi) --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-pie-chart me-2 text-success"></i>Komposisi Arsip</h6>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <canvas id="chartKomposisi" style="max-height: 250px;"></canvas>
                    </div>
                    <div class="card-footer bg-white border-0 text-center pb-3">
                        <small class="text-muted">Perbandingan Total Surat Masuk vs Keluar</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Tabel & Log --}}
        <div class="row">
            {{-- Tabel Surat Terbaru --}}
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-0">Aktivitas Surat Terbaru</h5>
                            <small class="text-muted">Data yang masuk ke sistem secara real-time</small>
                        </div>
                        <a href="{{ route('surat.masuk') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-uppercase small text-muted">
                                    <tr>
                                        <th class="ps-4">No. Surat</th>
                                        <th>Perihal</th>
                                        <th>Kategori</th>
                                        <th>Waktu</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    @forelse($suratTerbaru as $surat)
                                        <tr>
                                            <td class="ps-4 fw-medium text-primary">{{ $surat->nomor_surat }}</td>
                                            <td>{{ Str::limit($surat->nama_surat, 30) }}</td>
                                            <td>
                                                <span class="badge {{ $surat->category->jenis == 'masuk' ? 'bg-primary bg-opacity-10 text-primary' : 'bg-success bg-opacity-10 text-success' }} rounded-pill border border-0">
                                                    {{ ucfirst($surat->category->jenis) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $surat->created_at->format('H:i') }}</div>
                                                <small class="text-muted">{{ $surat->created_at->format('d/m/Y') }}</small>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('surat.show', $surat->id) }}" class="btn btn-sm btn-light text-primary"><i class="bi bi-eye-fill"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                Belum ada data surat tersedia.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Log Aktivitas --}}
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0">Log Aktivitas</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline-wrapper">
                            @forelse($logs as $log)
                                <div class="mb-3 border-bottom pb-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-bold small text-primary">
                                            <i class="bi bi-person-circle me-1"></i>{{ $log->user->nama_lengkap ?? 'System' }}
                                        </span>
                                        <small class="text-muted" style="font-size: 10px;">{{ $log->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0 small text-dark lh-sm">{{ $log->deskripsi }}</p>
                                </div>
                            @empty
                                <p class="text-center text-muted small py-4">Belum ada aktivitas tercatat.</p>
                            @endforelse
                        </div>
                        <a href="{{ route('admin.admin.logs') }}" class="btn btn-light btn-sm w-100 mt-2 border text-muted">Lihat Semua Log</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS (Clock & Charts) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // 1. Script Jam Digital
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

        // 2. Konfigurasi Chart.js
        document.addEventListener("DOMContentLoaded", function() {

            // A. Chart Bulanan (Bar)
            // Mengecek apakah elemen canvas ada
            const ctxBar = document.getElementById('chartBulanan');
            if(ctxBar) {
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                            label: 'Jumlah Surat',
                            // Mengambil data dari Controller (Pastikan Controller sudah diupdate)
                            data: {!! json_encode(array_values($dataBulanan ?? array_fill(0, 12, 0))) !!},
                            backgroundColor: 'rgba(13, 110, 253, 0.7)', // Warna Biru Bootstrap
                            borderColor: 'rgba(13, 110, 253, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                            x: { grid: { display: false } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }

            // B. Chart Komposisi (Doughnut)
            const ctxPie = document.getElementById('chartKomposisi');
            if(ctxPie) {
                new Chart(ctxPie, {
                    type: 'doughnut',
                    data: {
                        labels: ['Surat Masuk', 'Surat Keluar'],
                        datasets: [{
                            data: [{{ $totalMasuk ?? 0 }}, {{ $totalKeluar ?? 0 }}],
                            backgroundColor: ['#0d6efd', '#198754'], // Biru & Hijau
                            borderWidth: 0,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%', // Membuat lubang donat lebih besar
                        plugins: {
                            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                        }
                    }
                });
            }
        });
    </script>
@endsection
