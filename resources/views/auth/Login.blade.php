<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIMAS STMC</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --stmc-primary: #10b981; /* Hijau Emerald STMC */
            --stmc-primary-dark: #059669;
            --stmc-dark: #0f172a; /* Navy Gelap sesuai Sidebar */
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--stmc-dark) 0%, #1e293b 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; right: 0;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
            z-index: 0;
        }

        .login-card {
            position: relative;
            background: rgba(255, 255, 255, 1);
            border-radius: 24px;
            border: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 420px;
            padding: 40px;
            z-index: 1;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .form-label {
            color: #4b5563;
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            border-color: var(--stmc-primary);
        }

        .input-group-text {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            color: #9ca3af;
        }

        /* CSS Baru untuk Input Group agar lebih rapi */
        .input-group-text:first-child {
            border-radius: 12px 0 0 12px !important;
            border-right: none;
        }

        .input-group-text.toggle-password {
            border-radius: 0 12px 12px 0 !important;
            border-left: none;
            cursor: pointer; /* Mengubah kursor jadi tangan */
        }

        .form-control.password-input {
            border-radius: 0 !important;
            border-right: none;
        }

        .form-control:not(.password-input) {
            border-radius: 0 12px 12px 0 !important;
        }

        .btn-login {
            background: var(--stmc-primary);
            border: none;
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 1px;
            transition: all 0.3s;
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
        }

        .btn-login:hover {
            background: var(--stmc-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.4);
            color: white;
        }

        .back-link {
            text-decoration: none;
            font-size: 0.85rem;
            color: #9ca3af;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
        }

        .back-link:hover {
            color: var(--stmc-primary);
        }

        .register-link {
            color: var(--stmc-primary);
            font-weight: 700;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        .alert-custom {
            border-radius: 12px;
            border: none;
            background-color: #fef2f2;
            color: #991b1b;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>

    <div class="login-card animate__animated animate__fadeInUp">
        <div class="text-center mb-4">
            <div class="logo-container">
                <img src="{{ asset('Images/SemenTonasa.png') }}" alt="Logo Semen Tonasa" width="55">
                <img src="{{ asset('Images/STMC.png') }}" alt="Logo STMC" width="55">
            </div>
            <h4 class="fw-bold text-dark mt-3">SIMAS STMC</h4>
            <p class="text-muted small">Sistem Informasi Manajemen Arsip Surat</p>
        </div>

        @if($errors->any())
            <div class="alert alert-custom py-3 mb-4 animate__animated animate__shakeX">
                <div class="d-flex">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Email Pengguna</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="nama@email.com" required value="{{ old('email') }}">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control password-input" placeholder="••••••••" required>
                    <span class="input-group-text toggle-password" id="togglePasswordIcon">
                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100 mb-4">
                MASUK KE SISTEM <i class="bi bi-arrow-right-short ms-1"></i>
            </button>

            <div class="text-center">
                <p class="small text-muted mb-4">Belum memiliki akses? <a href="{{ route('register') }}" class="register-link">Daftar Akun</a></p>

                <div class="d-flex align-items-center mb-4">
                    <hr class="flex-grow-1 opacity-25">
                    <span class="mx-3 small text-muted opacity-50">STMC DIGITAL</span>
                    <hr class="flex-grow-1 opacity-25">
                </div>

                <a href="/" class="back-link">
                    <i class="bi bi-house-door me-2"></i> Kembali ke Beranda
                </a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('togglePasswordIcon').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            // Cek tipe input saat ini, jika password ubah ke text, jika text ubah ke password
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Ubah ikon mata menjadi mata terbuka
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                // Ubah ikon mata kembali menjadi mata dicoret
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            }
        });
    </script>
</body>
</html>
