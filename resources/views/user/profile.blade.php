@extends('layouts.Master')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    {{-- Bagian Header Halaman --}}
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark d-flex align-items-center">
                <div class="rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm" style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.1);">
                    <i class="bi bi-person-badge-fill" style="color: var(--stmc-primary); font-size: 1.2rem;"></i>
                </div>
                Pengaturan Profil & Keamanan
            </h4>
            <p class="text-muted ms-5 mb-0" style="font-size: 0.9rem;">Kelola informasi biodata diri dan perbarui kata sandi akun Anda secara berkala.</p>
        </div>
    </div>

    <div class="row g-4">
        {{-- KOLOM KIRI: INFORMASI PROFIL --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-person-circle me-2 text-success"></i> Informasi Personal
                    </h6>
                </div>
                <div class="card-body p-4 pt-0">
                    {{-- Visual Avatar --}}
                    <div class="text-center mb-4 p-3 bg-light rounded-4 border border-white">
                        <div class="rounded-circle d-flex justify-content-center align-items-center mx-auto mb-3 shadow-sm border border-3 border-white"
                             style="width: 80px; height: 80px; background: var(--stmc-primary); color: white; font-size: 2rem; font-weight: 700;">
                            {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                        </div>
                        <h5 class="fw-bold text-dark mb-0">{{ $user->nama_lengkap }}</h5>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-3 rounded-pill mt-2">
                            {{ strtoupper($user->role) }}
                        </span>
                    </div>

                    {{-- Alert Berhasil Profil --}}
                    @if (session('success_profile'))
                        <div class="alert alert-success border-0 shadow-sm mb-4 animate__animated animate__fadeInDown">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success_profile') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">NAMA LENGKAP</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="nama_lengkap" class="form-control border-light-subtle" value="{{ $user->nama_lengkap }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">ALAMAT EMAIL</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control border-light-subtle" value="{{ $user->email }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary">ROLE / JABATAN SISTEM</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-light border-light-subtle"><i class="bi bi-shield-check text-success"></i></span>
                                <input type="text" class="form-control bg-light border-light-subtle text-muted fw-bold" value="{{ strtoupper($user->role) }}" disabled>
                            </div>
                            <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">* Role jabatan tidak dapat diubah sendiri.</small>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 rounded-pill fw-bold shadow-sm" style="background-color: var(--stmc-primary); border: none;">
                            <i class="bi bi-check-circle me-2"></i> Simpan Perubahan Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: KEAMANAN AKUN --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-shield-lock me-2 text-danger"></i> Keamanan Akun
                    </h6>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="p-3 bg-danger bg-opacity-10 rounded-4 border border-danger-subtle mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill text-danger fs-4 me-3"></i>
                            <p class="mb-0 small text-danger fw-medium">Pastikan Anda menggunakan kata sandi yang kuat (kombinasi huruf, angka, dan simbol) untuk keamanan data arsip.</p>
                        </div>
                    </div>

                    {{-- Alert Berhasil Password --}}
                    @if (session('success_password'))
                        <div class="alert alert-success border-0 shadow-sm mb-4 animate__animated animate__fadeInDown">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success_password') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">PASSWORD SAAT INI</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-key text-muted"></i></span>
                                <input type="password" id="current_password" name="current_password" class="form-control border-light-subtle" placeholder="Masukkan password sekarang" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">PASSWORD BARU</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" id="new_password" name="password" class="form-control border-light-subtle" placeholder="Minimal 8 karakter" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">KONFIRMASI PASSWORD BARU</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-light-subtle"><i class="bi bi-shield-check text-muted"></i></span>
                                <input type="password" id="confirm_password" name="password_confirmation" class="form-control border-light-subtle" placeholder="Ulangi password baru" required>
                            </div>
                        </div>

                        <div class="form-check mb-4 d-flex align-items-center">
                            <input class="form-check-input me-2" type="checkbox" id="showAllPasswords" style="cursor: pointer;">
                            <label class="form-check-label small text-muted mt-1" for="showAllPasswords" style="cursor: pointer; user-select: none;">
                                Tampilkan semua sandi
                            </label>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 py-2 rounded-pill fw-bold shadow-sm" style="transition: 0.3s;">
                            <i class="bi bi-arrow-repeat me-2"></i> Update Password Keamanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('showAllPasswords').addEventListener('change', function() {
        const currentPass = document.getElementById('current_password');
        const newPass = document.getElementById('new_password');
        const confirmPass = document.getElementById('confirm_password');

        if(this.checked) {
            currentPass.type = 'text';
            newPass.type = 'text';
            confirmPass.type = 'text';
        } else {
            currentPass.type = 'password';
            newPass.type = 'password';
            confirmPass.type = 'password';
        }
    });
</script>
@endsection
