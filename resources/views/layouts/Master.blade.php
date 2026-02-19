<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | STMC Digital Klinik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    @stack('styles')

    <style>
        :root {
            --stmc-primary: #0d6efd;
            --stmc-dark: #2c3e50;
            --stmc-sidebar-bg: #1a252f;
            --sidebar-width: 280px;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            display: flex;
            font-size: 12px;
            line-height: 1;
        }

        .form-control,
        .form-select,
        .btn {
            font-size: 12px;
            padding: 0.5rem 0.75rem;
        }

        h5 {
            font-size: 1.1rem;
        }

        h6 {
            font-size: .95rem;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--stmc-sidebar-bg);
            color: white;
            transition: all 0.3s ease;
            z-index: 1050;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            background: rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .sidebar-content {
            flex-grow: 1;
            overflow-y: auto;
            padding-top: 1rem;
        }

        /* Scrollbar Sidebar */
        .sidebar-content::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-content::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Nav Link Styling */
        .nav-link {
            color: rgba(255, 255, 255, 0.6);
            margin: 0.2rem 1rem;
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            font-size: 12px;
            display: flex;
            align-items: center;
            transition: 0.2s ease;
        }

        .nav-link i {
            font-size: 1.1rem;
            width: 30px;
        }

        .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            color: white !important;
            background: var(--stmc-primary) !important;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        /* Main Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .top-navbar {
            background: white;
            height: 70px;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .content-body {
            padding: 2rem;
            flex: 1;
        }

        .sidebar-divider {
            margin: 1.5rem 1.5rem 0.5rem;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.3);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .sidebar.active {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar shadow" id="sidebar">
        <div class="sidebar-header">
            <div class="flex items-center gap-10">
                <img src="{{ asset('Images/SemenTonasa.png') }}" alt="Logo 1" width="45">
                <img src="{{ asset('Images/STMC.png') }}" alt="Logo 2" width="45">
            </div>
            <h6 class="fw-bold mb-0 text-white">SIMAS-STMC</h6>
            <span class="text-white-50" style="font-size: 10px; letter-spacing: 1px;">SISTEM MANAJEMEN INFORMASI ARSIP
                SURAT</span>
            <span class="text-white-50" style="font-size: 10px; letter-spacing: 1px;">SEMEN TONASA MEDICAL CENTER</span>
        </div>

        <div class="sidebar-content">
            <div class="sidebar-divider">Utama</div>
            <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="/profile" class="nav-link {{ Request::is('profile') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill"></i> Profil Saya
            </a>

            <div class="sidebar-divider">Arsip Surat</div>
            <a href="/surat/input" class="nav-link {{ Request::is('surat/input') ? 'active' : '' }}">
                <i class="bi bi-plus-square-fill"></i> Input Surat
            </a>
            <a href="/surat/masuk" class="nav-link {{ Request::is('surat/masuk*') ? 'active' : '' }}">
                <i class="bi bi-arrow-down-left-circle-fill"></i> Surat Masuk
            </a>
            <a href="/surat/keluar" class="nav-link {{ Request::is('surat/keluar*') ? 'active' : '' }}">
                <i class="bi bi-arrow-up-right-circle-fill"></i> Surat Keluar
            </a>
            <a href="/laporan" class="nav-link {{ Request::is('laporan*') ? 'active' : '' }}">
                <i class="bi bi-archive-fill"></i> Laporan / Rekap
            </a>

            @if (auth()->check() && auth()->user()->role == 'admin')
                <div class="sidebar-divider">Administrator</div>

                <div class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center {{ Request::is('admin*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#adminMenu" role="button"
                        aria-expanded="{{ Request::is('admin*') ? 'true' : 'false' }}">
                        <span>
                            <i class="bi bi-shield-lock-fill"></i> Panel Admin
                        </span>
                        <i class="bi bi-chevron-down ms-auto dropdown-arrow"
                            style="transition: 0.3s; font-size: 0.8rem;"></i>
                    </a>

                    <div class="collapse {{ Request::is('admin*') ? 'show' : '' }}" id="adminMenu">
                        <div class="bg-dark bg-opacity-25 mx-3 rounded-3 py-1 mb-2">
                            <a href="{{ route('admin.users.list') }}"
                                class="nav-link py-2 {{ Request::routeIs('admin.users.list') ? 'active' : '' }}"
                                style="margin: 0.2rem 0.5rem;">
                                <i class="bi bi-person-gear"></i> Manajemen User
                            </a>
                            <a href="{{ route('admin.users.index') }}"
                                class="nav-link py-2 {{ Request::routeIs('admin.users.index') ? 'active' : '' }}"
                                style="margin: 0.2rem 0.5rem;">
                                <i class="bi bi-person-check-fill"></i> Verifikasi
                            </a>
                            <a href="{{ route('admin.admin.logs') }}"
                                class="nav-link py-2 {{ Request::routeIs('admin.admin.logs') ? 'active' : '' }}"
                                style="margin: 0.2rem 0.5rem;">
                                <i class="bi bi-terminal"></i> Aktivitas
                            </a>
                            <a href="{{ route('admin.users.trash') }}"
                                class="nav-link py-2 {{ Request::routeIs('admin.users.trash') ? 'active' : '' }}"
                                style="margin: 0.2rem 0.5rem;">
                                <i class="bi bi-trash3-fill text-danger"></i> Arsip User
                            </a>
                            <a href="{{ route('admin.surat.trash') }}"
                                class="nav-link py-2 {{ Request::is('admin/surat/trash') ? 'active' : '' }}"
                                style="margin: 0.2rem 0.5rem;">
                                <i class="bi bi-trash-fill text-warning"></i> Sampah Surat
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <div style="padding: 15px; border-top: 1px solid rgba(255,255,255,0.1); margin-top: auto;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100 rounded-pill py-2">
                        <i class="bi bi-box-arrow-left me-2"></i> Keluar
                    </button>
                </form>
            </div>
    </aside>

    <main class="main-content">
        <header class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-light d-lg-none me-3" id="sidebarToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <span class="text-muted small d-none d-md-block fw-medium">
                    <i class="bi bi-calendar3 me-2 text-primary"></i>{{ date('d F Y') }}
                </span>
            </div>

            <div class="d-flex align-items-center">
                <div class="text-end me-3 d-none d-sm-block">
                    <p class="fw-bold mb-0 lh-1" style="font-size: 0.9rem;">{{ auth()->user()->nama_lengkap }}</p>
                    <small class="text-primary fw-bold text-uppercase"
                        style="font-size: 0.7rem; letter-spacing: 0.5px;">
                        {{ auth()->user()->role }}
                    </small>
                </div>
                <div class="bg-primary text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                    style="width: 42px; height: 42px; background: var(--stmc-primary) !important;">
                    <i class="bi bi-person-fill fs-5"></i>
                </div>
            </div>
        </header>

        <div class="content-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 animate__animated animate__fadeInDown"
                    role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div>
                            <strong>Berhasil!</strong> {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 animate__animated animate__shakeX"
                    role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <div>
                            <strong>Akses Ditolak!</strong> {{ session('error') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            {{-- AKHIR BAGIAN ALERT --}}

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Logika Sidebar Mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });
        }

        // Tutup sidebar jika user klik di luar pada tampilan mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 992) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
    </script>

    @stack('scripts')
</body>

</html
