<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')Sistem Informasi Manajemen Surat - STMC</title>
    <link rel="icon" type="image/png" href="/Images/STMC.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    @stack('styles')

    <style>
        /* 1. MENGECILKAN SELURUH TAMPILAN (GLOBAL) */
        html {
            /* Bawaan standar browser adalah 16px.
           Ubah ke 14px atau 15px agar semua elemen mengecil proporsional.
           Ukuran 14px adalah ukuran "Sweet Spot" untuk Admin Dashboard. */
            font-size: 14px !important;
        }

        /* 2. PENYESUAIAN TAMBAHAN (Opsional agar lebih rapi) */
        body {
            background-color: #f8fafc;
            /* Latar belakang abu-abu sangat muda agar mata tidak lelah */
        }

        /* Membuat jarak dalam tabel (padding) sedikit lebih rapat */
        .table td,
        .table th {
            padding: 0.6rem 0.75rem !important;
        }

        /* Mengecilkan sedikit sudut lengkung pada kartu agar terlihat lebih tajam & modern */
        .card {
            border-radius: 12px !important;
            /* Asalnya mungkin 16px atau 20px, kita buat lebih rapi */
        }

        /* Menyesuaikan input form agar tidak terlalu gemuk */
        .form-control,
        .form-select,
        .input-group-text {
            padding: 0.5rem 0.75rem;
        }

        :root {
            --stmc-primary: #10b981;
            --stmc-primary-dark: #059669;
            --stmc-dark: #0f172a;
            --stmc-sidebar-bg: #1e293b;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            /* Lebar saat dikecilkan */
        }

        body {
            background-color: #f3f4f6;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            display: flex;
            font-size: 13px;
            line-height: 1.5;
        }

        .form-control,
        .form-select,
        .btn {
            font-size: 13px;
            padding: 0.5rem 0.85rem;
            border-radius: 6px;
        }

        h5 {
            font-size: 1.15rem;
        }

        h6 {
            font-size: 1rem;
        }

        /* =========================================
           Sidebar Styling
           ========================================= */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--stmc-dark) 0%, var(--stmc-sidebar-bg) 100%);
            color: #d1d5db;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
        }

        .sidebar-header {
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.15);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
        }

        .sidebar-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1rem 0.8rem;
            overflow-x: hidden;
        }

        .sidebar-content::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-content::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }

        .sidebar-content::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .nav-link {
            color: #9ca3af;
            margin: 0.25rem 0;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            text-decoration: none;
            white-space: nowrap;
        }

        .nav-link i {
            font-size: 1.15rem;
            width: 32px;
            text-align: center;
            margin-right: 8px;
            transition: transform 0.2s ease;
        }

        .nav-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(4px);
        }

        .nav-link:hover i {
            transform: scale(1.1);
            color: var(--stmc-primary);
        }

        .nav-link.active {
            color: #ffffff !important;
            background: var(--stmc-primary) !important;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
            font-weight: 600;
        }

        .nav-link.active i {
            color: #ffffff !important;
        }

        .sidebar-divider {
            margin: 1.5rem 0.5rem 0.5rem;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #6b7280;
            white-space: nowrap;
        }

        #adminMenu .nav-link {
            font-size: 12px;
            padding: 0.6rem 1rem;
            margin-left: 0.5rem;
            border-left: 2px solid transparent;
            border-radius: 0 6px 6px 0;
        }

        #adminMenu .nav-link:hover {
            border-left-color: var(--stmc-primary);
            background: transparent;
            transform: translateX(2px);
        }

        #adminMenu .nav-link.active {
            background: rgba(16, 185, 129, 0.1) !important;
            color: var(--stmc-primary) !important;
            border-left-color: var(--stmc-primary);
            box-shadow: none;
        }

        .nav-link[aria-expanded="true"] .dropdown-arrow {
            transform: rotate(180deg);
        }

        .sidebar-footer {
            padding: 1rem;
            background: rgba(0, 0, 0, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            margin-top: auto;
        }

        .btn-panduan {
            background: rgba(255, 255, 255, 0.05);
            color: #60a5fa !important;
            border: 1px dashed rgba(96, 165, 250, 0.4);
        }

        .btn-panduan:hover {
            background: rgba(96, 165, 250, 0.1);
            color: #93c5fd !important;
            border-color: #60a5fa;
            transform: translateY(-2px);
        }

        /* =========================================
           Sidebar Collapsed State (Efek Dikecilkan)
           ========================================= */
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar.collapsed .sidebar-header {
            padding: 1.5rem 0.5rem;
        }

        /* Sembunyikan teks saat collapse */
        .sidebar.collapsed .sidebar-header h6,
        .sidebar.collapsed .sidebar-header div.text-white-50,
        .sidebar.collapsed .sidebar-header .logo-stmc,
        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .sidebar-divider,
        .sidebar.collapsed .dropdown-arrow,
        .sidebar.collapsed .btn-panduan span,
        .sidebar.collapsed .sidebar-footer form button span {
            display: none !important;
        }

        /* Sesuaikan posisi ikon saat collapse */
        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.8rem 0;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
            font-size: 1.3rem;
        }

        .sidebar.collapsed .sidebar-footer form button {
            padding: 0.8rem 0;
        }

        .sidebar.collapsed .sidebar-footer form button i {
            margin-right: 0 !important;
            font-size: 1.3rem;
        }

        .sidebar.collapsed #adminMenu .nav-link {
            margin-left: 0;
            justify-content: center;
        }

        /* =========================================
           Main Content Area
           ========================================= */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed~.main-content {
            margin-left: var(--sidebar-collapsed-width);
            width: calc(100% - var(--sidebar-collapsed-width));
        }

        .top-navbar {
            background: #ffffff;
            height: 70px;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Tombol Toggle di Navbar */
        .btn-toggle-sidebar {
            background: transparent;
            color: #4b5563;
            transition: all 0.2s;
        }

        .btn-toggle-sidebar:hover {
            background: #f3f4f6;
            color: var(--stmc-primary);
        }

        .content-body {
            padding: 2rem;
            flex: 1;
        }

        /* Responsive Mobile */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            .sidebar.collapsed {
                width: var(--sidebar-width);
            }

            .main-content,
            .sidebar.collapsed~.main-content {
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

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="d-flex justify-content-center align-items-center mb-2 gap-3">
                <img src="{{ asset('Images/SemenTonasa.png') }}" alt="Logo Semen Tonasa" width="45"
                    style="filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.5));">
                <img src="{{ asset('Images/STMC.png') }}" alt="Logo STMC" width="45" class="logo-stmc"
                    style="filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.5));">
            </div>
            <h6 class="fw-bold mb-1 text-white" style="letter-spacing: 0.5px;">SIMAS STMC</h6>
            <div class="text-white-50" style="font-size: 9px; letter-spacing: 0.5px; line-height: 1.2;">
                SISTEM MANAJEMEN INFORMASI ARSIP SURAT<br>SEMEN TONASA MEDICAL CENTER
            </div>
        </div>

        <div class="sidebar-content">
            <div class="sidebar-divider">Menu Utama</div>
            <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span>
            </a>
            <a href="/surat/input" class="nav-link {{ Request::is('surat/input') ? 'active' : '' }}">
                <i class="bi bi-cloud-arrow-up-fill text-success"
                    style="{{ Request::is('surat/input') ? 'color: white !important;' : '' }}"></i> <span>Input
                    Surat</span>
            </a>
            <a href="/profile" class="nav-link {{ Request::is('profile') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill"></i> <span>Profil Saya</span>
            </a>

            <div class="sidebar-divider">Manajemen Arsip</div>
            <a href="/surat/masuk" class="nav-link {{ Request::is('surat/masuk*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-down-right"></i> <span>Surat Masuk</span>
            </a>
            <a href="/surat/keluar" class="nav-link {{ Request::is('surat/keluar*') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-up-right"></i> <span>Surat Keluar</span>
            </a>
            <a href="/laporan" class="nav-link {{ Request::is('laporan*') ? 'active' : '' }}">
                <i class="bi bi-printer-fill text-info"
                    style="{{ Request::is('laporan*') ? 'color: white !important;' : '' }}"></i> <span>Cetak
                    Laporan</span>
            </a>

            @if (auth()->check() && auth()->user()->role == 'admin')
                <div class="sidebar-divider">Administrator</div>

                <div class="nav-item mb-2">
                    <a class="nav-link d-flex justify-content-between align-items-center {{ Request::is('admin*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#adminMenu" role="button" id="adminMenuToggle"
                        aria-expanded="{{ Request::is('admin*') ? 'true' : 'false' }}">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-shield-fill-check text-warning"
                                style="{{ Request::is('admin*') ? 'color: white !important;' : '' }}"></i>
                            <span>Panel Admin</span>
                        </div>
                        <i class="bi bi-chevron-down dropdown-arrow" style="transition: 0.3s; font-size: 0.8rem;"></i>
                    </a>

                    <div class="collapse {{ Request::is('admin*') ? 'show' : '' }} mt-1" id="adminMenu">
                        <div class="bg-dark bg-opacity-50 rounded-3 py-2 ms-2 me-1">
                            <a href="{{ route('admin.users.list') }}"
                                class="nav-link {{ Request::routeIs('admin.users.list') ? 'active' : '' }}">
                                <i class="bi bi-people-fill"></i> <span>Manajemen User</span>
                            </a>
                            <a href="{{ route('admin.users.index') }}"
                                class="nav-link {{ Request::routeIs('admin.users.index') ? 'active' : '' }}">
                                <i class="bi bi-person-check-fill"></i> <span>Verifikasi User</span>
                            </a>
                            <a href="{{ route('admin.logs') }}"
                                class="nav-link {{ Request::routeIs('admin.admin.logs') ? 'active' : '' }}">
                                <i class="bi bi-card-text"></i> <span>Log Aktivitas</span>
                            </a>
                            <a href="{{ route('admin.users.trash') }}"
                                class="nav-link {{ Request::routeIs('admin.users.trash') ? 'active' : '' }}">
                                <i class="bi bi-person-x-fill text-danger"></i> <span>Arsip User</span>
                            </a>
                            <a href="{{ route('admin.surat.trash') }}"
                                class="nav-link {{ Request::is('admin/surat/trash') ? 'active' : '' }}">
                                <i class="bi bi-trash3-fill text-danger"></i> <span>Sampah Surat</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="sidebar-footer">
            <a href="/Panduan_SIMAS.pdf" target="_blank"
                class="nav-link btn-panduan mb-3 justify-content-center fw-bold">
                <i class="bi bi-journal-bookmark-fill" style="margin:0; width:auto; margin-right:8px;"></i> <span>Buku
                    Panduan</span>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="btn btn-danger btn-sm w-100 rounded-2 py-2 fw-semibold d-flex align-items-center justify-content-center"
                    style="transition: 0.2s;">
                    <i class="bi bi-box-arrow-right me-2 fs-6"></i> <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <header class="top-navbar px-3 px-md-4">
            <div class="d-flex align-items-center">
                <button
                    class="btn btn-toggle-sidebar border-0 me-3 shadow-sm rounded-circle d-flex align-items-center justify-content-center"
                    id="mainSidebarToggle" style="width: 40px; height: 40px; transition: 0.3s;">
                    <i class="bi bi-list fs-4 text-dark"></i>
                </button>

                <div
                    class="d-none d-md-flex align-items-center bg-light px-3 py-2 rounded-pill border border-white shadow-sm">
                    <i class="bi bi-calendar3 me-2" style="color: var(--stmc-primary);"></i>
                    <span class="text-secondary small fw-bold"
                        style="letter-spacing: 0.5px;">{{ date('d F Y') }}</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 gap-md-3">
                <div class="text-end d-none d-sm-block">
                    <p class="fw-bold mb-0 lh-1 text-dark" style="font-size: 0.9rem;">
                        {{ auth()->user()->nama_lengkap }}
                    </p>
                    <small
                        class="badge bg-success bg-opacity-10 text-success border border-success-subtle rounded-pill px-2 mt-1"
                        style="font-size: 0.6rem; letter-spacing: 0.5px;">
                        {{ strtoupper(auth()->user()->role) }}
                    </small>
                </div>

                <div class="dropdown">
                    <div class="rounded-circle shadow-sm d-flex align-items-center justify-content-center border border-2 border-white"
                        style="width: 45px; height: 45px; background: var(--stmc-primary); color: white; fw-bold; cursor: pointer; transition: 0.3s;"
                        id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fw-bold" style="font-size: 1.1rem;">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}
                        </span>
                    </div>

                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3"
                        style="border-radius: 12px; min-width: 180px;">
                        <li><a class="dropdown-item py-2 small" href="/profile"><i
                                    class="bi bi-person me-2 text-success"></i> Profil Saya</a></li>
                        <li>
                            <hr class="dropdown-divider opacity-10">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 small text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Keluar Sistem
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="content-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 animate__animated animate__fadeInDown"
                    role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-3 fs-4 text-success"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Berhasil!</h6>
                            <small>{{ session('success') }}</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close mt-1" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 animate__animated animate__shakeX"
                    role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-3 fs-4 text-danger"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Peringatan!</h6>
                            <small>{{ session('error') }}</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close mt-1" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Logika DOM
        const sidebar = document.getElementById('sidebar');
        const mainToggle = document.getElementById('mainSidebarToggle');
        const adminMenuToggle = document.getElementById('adminMenuToggle');

        // 1. Cek State di LocalStorage untuk mode Desktop
        if (localStorage.getItem('sidebarState') === 'collapsed') {
            if (window.innerWidth > 992) {
                sidebar.classList.add('collapsed');
            }
        }

        // 2. Tombol Hamburger Menu (Mengatur Desktop & Mobile sekaligus)
        if (mainToggle) {
            mainToggle.addEventListener('click', () => {
                if (window.innerWidth > 992) {
                    // Mode Layar Besar: Toggle ukuran mini
                    sidebar.classList.toggle('collapsed');
                    localStorage.setItem('sidebarState', sidebar.classList.contains('collapsed') ? 'collapsed' :
                        'expanded');
                } else {
                    // Mode HP: Tampilkan / Sembunyikan sidebar penuh
                    sidebar.classList.toggle('active');
                }
            });
        }

        // 3. Auto Expand jika klik Panel Admin tapi sidebar sedang dikecilkan
        if (adminMenuToggle) {
            adminMenuToggle.addEventListener('click', () => {
                if (sidebar.classList.contains('collapsed')) {
                    sidebar.classList.remove('collapsed');
                    localStorage.setItem('sidebarState', 'expanded');
                }
            });
        }

        // 4. Tutup sidebar jika klik di luar (khusus tampilan mobile)
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 992) {
                if (!sidebar.contains(e.target) && !mainToggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
