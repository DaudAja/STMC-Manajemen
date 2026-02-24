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
    // 1. Statistik Surat Hari Ini (Berdasarkan Jenis)
    $masukHariIni = Surat::whereHas('category', function($q) {
        $q->where('jenis', 'masuk');
    })->whereDate('created_at', today())->count();

    $keluarHariIni = Surat::whereHas('category', function($q) {
        $q->where('jenis', 'keluar');
    })->whereDate('created_at', today())->count();

    // 2. Statistik Berdasarkan Sifat (Internal vs Eksternal)
    $internalCount = Surat::whereHas('category', function($q) {
        $q->where('sifat', 'internal');
    })->count();

    $externalCount = Surat::whereHas('category', function($q) {
        $q->where('sifat', 'external');
    })->count();

    $totalSemuaSurat = Surat::count();

    // 3. Data untuk Grafik Donat (Total Tahun Ini) - DISESUAIKAN
    $totalMasuk = Surat::whereHas('category', function($q) {
        $q->where('jenis', 'masuk');
    })->whereYear('tanggal_surat', date('Y'))->count();

    $totalKeluar = Surat::whereHas('category', function($q) {
        $q->where('jenis', 'keluar');
    })->whereYear('tanggal_surat', date('Y'))->count();

    // 4. DATA UNTUK GRAFIK BATANG STACKED (Per Bulan)

    // A. Ambil data Surat Masuk per bulan berdasarkan TANGGAL SURAT
    $suratMasukPerBulan = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'masuk');
        })
        ->select(DB::raw('MONTH(tanggal_surat) as bulan'), DB::raw('COUNT(*) as total'))
        ->whereYear('tanggal_surat', date('Y')) // Berdasarkan tahun surat
        ->groupBy('bulan')
        ->pluck('total', 'bulan')->toArray();

    // B. Ambil data Surat Keluar per bulan berdasarkan TANGGAL SURAT
    $suratKeluarPerBulan = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'keluar');
        })
        ->select(DB::raw('MONTH(tanggal_surat) as bulan'), DB::raw('COUNT(*) as total'))
        ->whereYear('tanggal_surat', date('Y')) // Berdasarkan tahun surat
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
        'internalCount', 'externalCount',
        'totalMasuk', 'totalKeluar',
        'masukBulanan', 'keluarBulanan', 
        'suratTerbaru', 'logs', 'totalSemuaSurat',
    ));
}
}
