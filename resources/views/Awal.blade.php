<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMAS - STMC | Sistem Informasi Manajemen Arsip Surat</title>

    <link rel="icon" type="image/png" href="/Images/STMC.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            /* Warna diselaraskan dengan Master.blade.php (Tema STMC) */
            --stmc-primary: #10b981; /* Hijau Medis */
            --stmc-primary-dark: #059669;
            --stmc-dark: #111827; /* Hitam elegan */
            --stmc-accent: #ef4444; /* Merah Semen Tonasa (Aksen) */
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Sama dengan body Master */
            margin: 0;
            padding: 0;
        }

        /* Hero Section */
        .hero {
            position: relative;
            min-height: 100vh;
            /* Latar belakang menggunakan gradasi gelap elegan ala Master */
            background: linear-gradient(135deg, var(--stmc-dark) 0%, #1e293b 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px 150px 20px; /* Ruang bawah untuk gelombang */
            overflow: hidden;
        }

        /* Efek cahaya halus di background */
        .hero::before {
            content: "";
            position: absolute;
            top: -20%; right: -10%;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 1;
        }

        /* Glassmorphism Card Utama */
        .glass-card {
            position: relative;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            padding: 50px 40px;
            color: white;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            max-width: 800px;
            width: 100%;
            z-index: 2;
        }

        /* Logo Styling */
        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .logo-img {
            /* Shadow menyesuaikan bentuk logo asli, tanpa background putih */
            filter: drop-shadow(0px 4px 8px rgba(0,0,0,0.6));
            transition: transform 0.3s ease;
        }

        .logo-img:hover {
            transform: scale(1.05);
        }

        /* Tombol Modern */
        .btn-modern {
            padding: 12px 35px;
            border-radius: 8px; /* Disesuaikan dengan Master */
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-login {
            background: var(--stmc-primary);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-login:hover {
            background: var(--stmc-primary-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-outline-custom {
            background: transparent;
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .btn-outline-custom:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-color: white;
            transform: translateY(-2px);
        }

        /* Fitur Card */
        .feature-box {
            position: relative;
            z-index: 2;
            color: white;
            margin-top: 50px;
            max-width: 1000px;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            padding: 30px 20px;
            text-align: center;
            transition: 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.05);
            height: 100%;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-5px);
            border-color: rgba(16, 185, 129, 0.3); /* Hover border warna hijau */
        }

        .feature-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px; height: 60px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.1);
            color: var(--stmc-primary);
            margin-bottom: 15px;
        }

        /* Gelombang Putih di Bawah */
        .wave-container {
            position: absolute;
            bottom: -1px; /* Mencegah garis batas tipis */
            left: 0;
            width: 100%;
            line-height: 0;
            z-index: 1;
        }

        .wave-container svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 120px;
        }

        .wave-container .shape-fill {
            fill: #f3f4f6; /* Diselaraskan dengan warna body */
        }
    </style>
</head>
<body>

    <section class="hero">
        <div class="glass-card animate__animated animate__fadeInDown">
            <div class="logo-container">
                <img src="{{ asset('Images/SemenTonasa.png') }}" alt="Logo Semen Tonasa" width="75" class="logo-img">
                <img src="{{ asset('Images/STMC.png') }}" alt="Logo STMC" width="75" class="logo-img">
            </div>

            <div class="text-center">
                <h1 class="fw-bold mb-3" style="letter-spacing: 1px;">SIMAS STMC</h1>
                <p class="fs-6 mb-1 text-white-50" style="letter-spacing: 2px;">SISTEM MANAJEMEN INFORMASI ARSIP SURAT</p>
                <p class="fs-6 mb-4 text-white-50" style="letter-spacing: 2px;">SEMEN TONASA MEDICAL CENTER</p>

                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">
                    <a href="{{ route('login') }}" class="btn btn-modern btn-login">
                        <i class="bi bi-door-open-fill me-2 fs-5"></i> Masuk Sistem
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-modern btn-outline-custom">
                        <i class="bi bi-person-plus-fill me-2 fs-5"></i> Daftar Akun
                    </a>
                </div>
            </div>
        </div>

        <div class="container feature-box animate__animated animate__fadeInUp animate__delay-1s">
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Terverifikasi</h5>
                        <p class="small text-white-50 mb-0">Persetujuan admin mutlak diperlukan untuk keamanan data.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-file-earmark-pdf fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Arsip Digital</h5>
                        <p class="small text-white-50 mb-0">Simpan bukti fisik dalam format digital yang rapi dan terpusat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="bi bi-clock-history fs-2"></i>
                        </div>
                        <h5 class="fw-bold">Riwayat Log</h5>
                        <p class="small text-white-50 mb-0">Pantau setiap aksi yang dilakukan oleh pengguna secara real-time.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="wave-container">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C51.17,101.8,105.74,105,159.44,95.83c66-11.3,123.63-29.61,161.95-39.39Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>

</body>
</html>
