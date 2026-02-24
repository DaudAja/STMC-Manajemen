<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\ActivityLog;

class SuratController extends Controller
{
    // 1. Fungsi untuk dipanggil JavaScript saat memilih Sifat & Jenis
    public function getCategories($sifat, $jenis)
    {
        $categories = Category::where('sifat', $sifat)
            ->where('jenis', $jenis)
            ->get();

        return response()->json($categories);
    }

    // 2. Fungsi AJAX untuk mendapatkan nomor surat otomatis
    public function getNomorAjax($categoryId)
    {
        $nomor = $this->generateNomorSurat($categoryId);
        return response()->json(['nomor' => $nomor]);
    }

    // 3. Inti Logika Penomoran (Dinamis)
    private function generateNomorSurat($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $tahun = date('Y');
        $bulanDigit = date('m'); // FORMAT BULAN ANGKA (01, 02, dst)

        // Hitung urutan berdasarkan kategori tersebut di tahun ini
        $urutan = Surat::withTrashed()
            ->where('category_id', $categoryId)
            ->whereYear('created_at', $tahun)
            ->count() + 1;

        $no = str_pad($urutan, 3, '0', STR_PAD_LEFT);

        // Variabel pengganti untuk Placeholder di format_nomor
        $map = [
            '{no}'    => $no,
            '{bulan}' => $bulanDigit,
            '{tahun}' => $tahun,
        ];

        // Mengambil pola dari database (Contoh: {no}/Ext/ST/...)
        // lalu mengganti placeholder dengan data asli
        return str_replace(array_keys($map), array_values($map), $category->format_nomor);
    }

    // 1. FUNGSI UNTUK MENAMPILKAN FORM INPUT
    public function input()
    {
        // Ambil semua kategori untuk ditampilkan di dropdown
        $category = Category::all();

        return view('surat.tambah', compact('category'));
    }

    // 2. FUNGSI UNTUK PROSES SIMPAN (POST)
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'category_id'   => 'required|exists:categories,id', // Validasi kategori
            'nama_surat'    => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'foto_bukti'    => 'required|file|mimes:pdf|max:5120',
            'nomor_surat'   => 'required|unique:surats,nomor_surat',
        ]);

        // Proses upload file
        $nama_file = null;
        if ($request->hasFile('foto_bukti')) {
            $path = $request->file('foto_bukti')->store('surat', 'public');
            $nama_file = basename($path);
        }

        // Simpan Data
        $surat = Surat::create([
            'user_id'       => Auth::id(),
            'category_id'   => $request->category_id,
            'nomor_surat'   => $request->nomor_surat,
            'nama_surat'    => $request->nama_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'foto_bukti'    => $nama_file,
        ]);

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => 'Tambah Surat',
            'deskripsi'  => "Menambahkan surat baru dengan nomor: {$surat->nomor_surat}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Surat berhasil diarsipkan!');
    }

    // 3. FUNGSI UNTUK MENAMPILKAN DETAIL SURAT
    public function show(Surat $surat)
    {
        // Memastikan data user ikut dipanggil
        $surat->load('user');
        return view('surat.detail', compact('surat'));
    }

    // 4. FUNGSI UNTUK MENAMPILKAN FORM EDIT
    public function edit($id)
    {
        $surat = Surat::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $surat->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit surat ini.');
        }

        $category = Category::all();

        return view('surat.edit', compact('surat', 'category'));
    }

    public function update(Request $request, $id)
    {
        $surat = Surat::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $surat->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit surat ini.');
        }

        $validated = $request->validate([
            'nama_surat'    => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'foto_bukti'    => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // Cek jika user upload file baru
        if ($request->hasFile('foto_bukti')) {
            // Hapus file lama fisik jika ada
            if ($surat->foto_bukti && Storage::disk('public')->exists('surat/' . $surat->foto_bukti)) {
                Storage::disk('public')->delete('surat/' . $surat->foto_bukti);
            }

            // Simpan file baru
            $path = $request->file('foto_bukti')->store('surat', 'public');
            $surat->foto_bukti = basename($path);
        }

        // Update Data Lainnya
        $surat->nama_surat    = $validated['nama_surat'];
        $surat->tanggal_surat = $validated['tanggal_surat'];

        if ($surat->category->jenis == 'masuk' && $request->filled('nomor_surat')) {
            $surat->nomor_surat = $request->nomor_surat;
        }

        $surat->save();

        // Catat Log
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => 'Edit Surat',
            'deskripsi'  => "Mengedit data surat nomor: {$surat->nomor_surat}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('surat.show', $surat->id)->with('success', 'Data surat berhasil diperbaiki!');
    }

    // 5. FUNGSI UNTUK HAPUS (SOFT DELETE)
    public function destroy($id)
    {
        // 1. Cari data surat
        $surat = Surat::findOrFail($id);

        // 2. Proteksi: Surat Keluar tidak boleh dihapus
        if ($surat->category->jenis == 'keluar') {
            return redirect()->back()->with('error', 'Surat Keluar tidak boleh dihapus agar nomor urut tidak hilang. Gunakan fitur Edit jika ada kesalahan.');
        }

        // 3. Proteksi: Cek Izin (Admin atau Pemilik)
        if (Auth::user()->role !== 'admin' && Auth::id() !== $surat->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus surat ini.');
        }

        // 4. Proses Soft Delete
        $surat->delete();

        // 5. Catat Log
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => 'Hapus Surat (Soft Delete)',
            'deskripsi'  => "Menghapus sementara surat nomor: {$surat->nomor_surat}",
            'ip_address' => request()->ip(),
        ]);

        // Kembali ke halaman sebelumnya (lebih nyaman untuk user)
        return redirect()->back()->with('success', 'Surat berhasil dipindahkan ke tempat sampah.');
    }

    // 5. Menampilkan Data yang Sudah di Hapus (Trash)
    public function trash()
    {
        // onlyTrashed() mengambil data yang sudah di soft-delete
        $data = Surat::onlyTrashed()->with('category', 'user')->get();
        return view('surat.trash', compact('data'));
    }

    // 2. Mengembalikan data (Restore)
    public function restore($id)
    {
        // findWithTrashed mencari data meskipun sudah di-delete
        $surat = Surat::withTrashed()->findOrFail($id);
        $surat->restore();

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => 'Restore Surat',
            'deskripsi'  => "Mengembalikan surat nomor: {$surat->nomor_surat} dari tempat sampah",
            'ip_address' => request()->ip(),
        ]);

        return redirect()->back()->with('success', 'Surat berhasil dikembalikan.');
    }

    // 6. FUNGSI UNTUK CETAK LAPORAN (Berdasarkan Tanggal & Jenis)
    public function laporanForm()
    {
        return view('laporan.index');
    }

    public function laporanCetak(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'tgl_awal'    => 'required|date',
            'tgl_akhir'   => 'required|date|after_or_equal:tgl_awal',
            'jenis_surat' => 'required|in:semua,masuk,keluar',
        ]);

        $awal  = $request->tgl_awal;
        $akhir = $request->tgl_akhir;
        $jenis = $request->jenis_surat;

        // 2. Query Data dengan Relasi
        $query = Surat::with(['category', 'user']);

        // A. Filter Tanggal
        $query->whereBetween('tanggal_surat', [$awal, $akhir]);

        // B. Filter Jenis (INI YANG DIPERBAIKI)
        // Kita cari 'jenis' di dalam tabel 'category', bukan di tabel 'surat'
        if ($jenis !== 'semua') {
            $query->whereHas('category', function ($q) use ($jenis) {
                $q->where('jenis', $jenis);
            });
        }

        // 3. Ambil Data
        $data = $query->orderBy('tanggal_surat', 'asc')->get();

        return view('laporan.cetak', compact('data', 'awal', 'akhir', 'jenis'));
    }

    // 7. FUNGSI UNTUK HAPUS PERMANEN (Force Delete)
    public function forceDelete($id)
    {
        // Cari data yang sudah di-trash
        $surat = Surat::withTrashed()->findOrFail($id);
        $nomorSurat = $surat->nomor_surat;

        // 1. Hapus File Fisik PDF dari Storage agar hemat ruang hosting
        if ($surat->foto_bukti) {
            $filePath = public_path('storage/surat/' . $surat->foto_bukti);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // 2. Hapus Permanen dari Database
        $surat->forceDelete();

        // 3. Catat Log Aktivitas
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'aksi'       => 'Hapus Permanen',
            'deskripsi'  => "Menghapus selamanya surat nomor: {$nomorSurat} dan file fisiknya.",
            'ip_address' => request()->ip(),
        ]);

        return redirect()->back()->with('success', 'Surat berhasil dihapus secara permanen dari server.');
    }


    // 8. FUNGSI UNTUK DOWNLOAD FILE SURAT
    public function download($id)
    {
        $surat = Surat::findOrFail($id);

        // LOGIKA PERBAIKAN: Gunakan Path File (Folder + Nama), bukan Objek Surat
        $filePath = 'surat/' . $surat->foto_bukti;

        // Catat Log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => 'Download Surat',
            'deskripsi' => "Mendownload file surat dengan nomor: {$surat->nomor_surat}",
            'ip_address' => request()->ip(),
        ]);

        // Cek apakah file fisik ada di storage
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download($filePath, $surat->foto_bukti);
        } else {
            return redirect()->back()->with('error', 'File fisik tidak ditemukan di server.');
        }
    }

    // FUNGSI UNTUK SURAT MASUK
    public function Masuk(Request $request)
    {
        $search = $request->get('search');

        // Query Dasar
        $baseQuery = function ($sifat) use ($search) {
            return Surat::with('category', 'user')
                ->whereHas('category', function ($q) use ($sifat) {
                    $q->where('jenis', 'masuk')->where('sifat', $sifat);
                })
                ->when($search, function ($q) use ($search) {
                    $q->where(function ($sq) use ($search) {
                        $sq->where('nomor_surat', 'LIKE', "%$search%")
                            ->orWhere('nama_surat', 'LIKE', "%$search%");
                    });
                });
        };

        $internal = $baseQuery('internal')->latest()->get();
        $external = $baseQuery('external')->latest()->get();

        return view('surat.masuk', compact('internal', 'external'));
    }

    // FUNGSI UNTUK SURAT KELUAR
    public function Keluar(Request $request)
    {
        $search = $request->get('search');

        // Query Dasar
        $baseQuery = function ($sifat) use ($search) {
            return Surat::with('category', 'user')
                ->whereHas('category', function ($q) use ($sifat) {
                    $q->where('jenis', 'keluar')->where('sifat', $sifat);
                })
                ->when($search, function ($q) use ($search) {
                    $q->where(function ($sq) use ($search) {
                        $sq->where('nomor_surat', 'LIKE', "%$search%")
                            ->orWhere('nama_surat', 'LIKE', "%$search%");
                    });
                });
        };

        $internal = $baseQuery('internal')->latest()->get();
        $external = $baseQuery('external')->latest()->get();

        return view('surat.keluar', compact('internal', 'external'));
    }
}
