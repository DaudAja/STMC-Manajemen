<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | SIMAS STMC</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --stmc-primary: #10b981;
            --stmc-primary-dark: #059669;
            --stmc-dark: #0f172a;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--stmc-dark) 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .register-card {
            background: #ffffff;
            border-radius: 20px; /* Sudut sedikit lebih tegas tapi tetap modern */
            border: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 440px; /* UKURAN LEBIH KECIL/COMPACT */
            padding: 30px; /* Padding dikurangi agar pas dengan ukuran kecil */
            position: relative;
        }

        @media (max-width: 576px) {
            .register-card { padding: 25px 20px; }
            .logo-container img { width: 45px; }
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .form-label {
            color: #4b5563;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-control {
            border-radius: 10px;
            padding: 9px 12px; /* Ukuran input lebih ramping */
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
            font-size: 0.9rem;
        }

        .form-control:focus {
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            border-color: var(--stmc-primary);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px !important;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-right: none;
            color: #9ca3af;
            padding: 0 12px;
        }

        .form-control-with-icon {
            border-radius: 0 10px 10px 0 !important;
        }

        .btn-register {
            background: var(--stmc-primary);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            box-shadow: 0 8px 15px -3px rgba(16, 185, 129, 0.3);
        }

        .btn-register:hover {
            background: var(--stmc-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 15px 20px -5px rgba(16, 185, 129, 0.4);
        }

        .login-link {
            color: var(--stmc-primary);
            font-weight: 700;
            text-decoration: none;
        }

        .back-link {
            text-decoration: none;
            font-size: 0.8rem;
            color: #9ca3af;
            transition: 0.3s;
        }

        .alert-custom {
            border-radius: 10px;
            font-size: 0.75rem;
            padding: 10px;
        }
    </style>
</head>
<body>

    <div class="register-card animate__animated animate__fadeInUp">
        <div class="text-center mb-3">
            <div class="logo-container">
                <img src="{{ asset('Images/SemenTonasa.png') }}" alt="Logo" width="48">
                <img src="{{ asset('Images/STMC.png') }}" alt="Logo" width="48">
            </div>
            <h5 class="fw-bold text-dark mt-2 mb-1" style="font-size: 1.15rem;">Daftar Akun</h5>
            <p class="text-muted small mb-0">Sistem Manajemen Arsip Surat STMC</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-custom mb-3 animate__animated animate__shakeX">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-2">
                <label class="form-label">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="nama_lengkap" class="form-control form-control-with-icon" placeholder="Nama Anda" required value="{{ old('nama_lengkap') }}">
                </div>
            </div>

            <div class="mb-2">
                <label class="form-label">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control form-control-with-icon" placeholder="nama@email.com" required value="{{ old('email') }}">
                </div>
            </div>

            <div class="mb-2">
                <label class="form-label">Nomor Telepon</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                    <input type="text" name="no_telepon" class="form-control form-control-with-icon" placeholder="08123..." required value="{{ old('no_telepon') }}">
                </div>
            </div>

            <div class="row g-2 mb-3">
                <div class="col-6">
                    <label class="form-label">Sandi</label>
                    <input type="password" name="password" class="form-control" placeholder="••••" required>
                </div>
                <div class="col-6">
                    <label class="form-label">Ulangi</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-register w-100 mb-3">
                DAFTAR SEKARANG <i class="bi bi-check-circle-fill ms-1"></i>
            </button>

            <div class="text-center">
                <p class="small text-muted mb-2">Sudah ada akun? <a href="{{ route('login') }}" class="login-link">Masuk</a></p>
                <hr class="opacity-10 my-3">
                <a href="/" class="back-link">
                    <i class="bi bi-arrow-left me-1"></i> Beranda
                </a>
            </div>
        </form>
    </div>

</body>
</html>
