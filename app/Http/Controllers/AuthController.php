<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            ActivityLog::create([
                'user_id' => $user->id,
                'aksi' => 'Login',
                'deskripsi' => 'User masuk ke sistem.',
                'ip_address' => $request->ip(),
            ]);

            // Cek status user setelah login
            if ($user->status === 'inactive') {
                return redirect()->route('account.inactive');
            } elseif ($user->status === 'pending') {
                return redirect()->route('waiting.verification');
            } elseif ($user->status === 'active') {
                return redirect()->route('dashboard');
            }
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Menampilkan Halaman Registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses Registrasi
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'no_telepon' => 'required|string|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat user baru dengan status 'pending'
        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'pending',
        ]);

        // Otomatis login setelah registrasi
        Auth::login($user);

        // Catat aktivitas registrasi dan auto-login
        ActivityLog::create([
            'user_id' => $user->id,
            'aksi' => 'Register & Auto-Login',
            'deskripsi' => 'User baru mendaftar dan otomatis masuk ke sistem.',
            'ip_address' => $request->ip(),
        ]);

        // Cek status user setelah registrasi
        if ($user->status === 'active') {
            return redirect()->route('dashboard');
        } elseif ($user->status === 'pending') {
            return redirect()->route('waiting.verification');
        } else {
            return redirect()->route('account.inactive');
        }

    }

    // Proses Logout
    public function logout(Request $request)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Logout',
            'deskripsi' => 'User keluar dari sistem.',
            'ip_address' => $request->ip(),
        ]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
