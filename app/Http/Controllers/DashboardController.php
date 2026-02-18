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
        // 1. Statistik Surat Masuk (Menghitung melalui relasi kategori)
        $masukHariIni = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'masuk');
        })->whereDate('created_at', today())->count();

        // 2. Statistik Surat Keluar (Menghitung melalui relasi kategori)
        $keluarHariIni = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'keluar');
        })->whereDate('created_at', today())->count();

        // 3. Tambahan: Statistik Berdasarkan Sifat (Poin Plus KPI)
        $internalCount = Surat::whereHas('category', function($q) {
            $q->where('sifat', 'internal');
        })->count();

        $externalCount = Surat::whereHas('category', function($q) {
            $q->where('sifat', 'external');
        })->count();

        // 4. Ambil 5 Surat Terbaru dengan relasi kategorinya agar tidak lambat (Eager Loading)
        $suratTerbaru = Surat::with('category')->latest()->take(5)->get();

        // 5. Ambil data logs terbaru
        $logs = ActivityLog::with('user')->latest()->take(5)->get();

        // 2. DATA UNTUK CHART (BARU)

        // A. Perbandingan Masuk vs Keluar (Total Tahunan)
        $totalMasuk = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'masuk');
        })->whereYear('created_at', date('Y'))->count();

        $totalKeluar = Surat::whereHas('category', function($q) {
            $q->where('jenis', 'keluar');
        })->whereYear('created_at', date('Y'))->count();

        // B. Statistik Surat Per Bulan (Tahun Ini)
        $suratPerBulan = Surat::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('total', 'bulan')->toArray();

        // Normalisasi data bulanan (isi 0 jika bulan kosong)
        $dataBulanan = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataBulanan[] = $suratPerBulan[$i] ?? 0;
        }

        // 3. DATA TABEL & LOGS
        $suratTerbaru = Surat::with('category')->latest()->take(5)->get();
        $logs = ActivityLog::with('user')->latest()->take(5)->get();

        return view('Dashboard', compact(
            'masukHariIni', 'keluarHariIni',
            'internalCount', 'externalCount',
            'totalMasuk', 'totalKeluar', 'dataBulanan', // Variable baru untuk chart
            'suratTerbaru', 'logs'
        ));
    }
}
