<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'aksi', 'deskripsi', 'ip_address'];

    public static function record($aksi, $deskripsi)
    {
        self::create([
            'user_id' => Auth::id(),
            'aksi' => $aksi,
            'deskripsi' => $deskripsi,
            'ip_address' => Request::ip(),
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        // Event 'created' akan menyala OTOMATIS setiap kali ada log baru yang masuk ke database
        static::created(function ($model) {

            // Sistem "Lotere" (Peluang 1 banding 20)
            // Tujuannya agar server tidak keberatan harus mengecek dan menghapus data SETIAP DETIK.
            // Cukup lakukan pengecekan sesekali saja secara acak saat ada aktivitas.
            if (rand(1, 20) === 1) {

                // Cari batas waktu (Misal: 30 hari yang lalu dari detik ini)
                $batasWaktu = Carbon::now()->subDays(90);

                // Eksekusi hapus permanen tanpa peringatan
                self::where('created_at', '<', $batasWaktu)->delete();
            }
        });
    }
}

