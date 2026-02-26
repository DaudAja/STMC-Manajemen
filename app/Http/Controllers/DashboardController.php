<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Surat Hari Ini
        $masukHariIni = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'masuk');
        })->whereDate('created_at', today())->count();

        $keluarHariIni = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'keluar');
        })->whereDate('created_at', today())->count();

        // 2. STATISTIK DETAIL (Masuk & Keluar Dipecah Berdasarkan Sifat) - INI YANG BARU ✨
        $masukInternal = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'masuk')->where('sifat', 'internal');
        })->count();

        $masukExternal = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'masuk')->where('sifat', 'external');
        })->count();

        $keluarInternal = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'keluar')->where('sifat', 'internal');
        })->count();

        $keluarExternal = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'keluar')->where('sifat', 'external');
        })->count();

        $totalSemuaSurat = Surat::count();

        // 3. Data untuk Grafik Donat (Total Keseluruhan Tahun Ini)
        $totalMasuk = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'masuk');
        })->whereYear('tanggal_surat', date('Y'))->count();

        $totalKeluar = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'keluar');
        })->whereYear('tanggal_surat', date('Y'))->count();

        // 4. DATA UNTUK GRAFIK BATANG STACKED (Per Bulan)
        $suratMasukPerBulan = Surat::whereHas('category', function($q) {
                $q->where('jenis', 'masuk');
            })
            ->select(DB::raw('MONTH(tanggal_surat) as bulan'), DB::raw('COUNT(*) as total'))
            ->whereYear('tanggal_surat', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan')->toArray();

        $suratKeluarPerBulan = Surat::whereHas('category', function($q) {
                $q->where('jenis', 'keluar');
            })
            ->select(DB::raw('MONTH(tanggal_surat) as bulan'), DB::raw('COUNT(*) as total'))
            ->whereYear('tanggal_surat', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan')->toArray();

        // C. Normalisasi data untuk 12 bulan
        $masukBulanan = [];
        $keluarBulanan = [];
        for ($i = 1; $i <= 12; $i++) {
            $masukBulanan[] = $suratMasukPerBulan[$i] ?? 0;
            $keluarBulanan[] = $suratKeluarPerBulan[$i] ?? 0;
        }

        // 5. Ambil 5 Surat Terbaru & Log Aktivitas (Eager Loading)
        $suratTerbaru = Surat::with('category')->latest()->take(5)->get();
        $logs = ActivityLog::with('user')->latest()->take(5)->get();

        // 6. Kirim semua variabel ke View Dashboard
        return view('Dashboard', compact(
            'masukHariIni', 'keluarHariIni',
            'masukInternal', 'masukExternal',   // Variabel Baru
            'keluarInternal', 'keluarExternal', // Variabel Baru
            'totalMasuk', 'totalKeluar',
            'masukBulanan', 'keluarBulanan',
            'suratTerbaru', 'logs', 'totalSemuaSurat',
        ));
    }
}
