<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Arsip Surat - STMC</title>
    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* CSS Khusus Cetak */
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
            a { text-decoration: none !important; color: black !important; }
        }

        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; }

        /* Kop Surat */
        .kop-surat { border-bottom: 3px double black; margin-bottom: 20px; padding-bottom: 10px; }

        /* --- PERBAIKAN GARIS HITAM --- */
        /* Memaksa semua garis tabel (luar & dalam) berwarna hitam pekat */
        .table-bordered,
        .table-bordered > thead > tr > th,
        .table-bordered > tbody > tr > th,
        .table-bordered > tfoot > tr > th,
        .table-bordered > thead > tr > td,
        .table-bordered > tbody > tr > td,
        .table-bordered > tfoot > tr > td {
            border: 1px solid #000000 !important;
            border-color: #000000 !important;
        }

        /* Warna Header Tabel */
        .table th {
            background-color: #4d83ba !important;
            color: black !important;
        }

        /* Kotak QR Code */
        .qr-box { border: 1px solid #000; padding: 2px; display: inline-block; }
    </style>
</head>

{{-- Otomatis muncul dialog print saat halaman dibuka --}}
<body onload="window.print()">

    <div class="container-fluid mt-4">

        {{-- Tombol Kembali (Hilang saat diprint) --}}
        <div class="d-flex justify-content-between mb-3 no-print">
            <button onclick="window.close()" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali / Tutup</button>
            <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Print Ulang</button>
        </div>

        {{-- KOP SURAT --}}
        <div class="text-center kop-surat">
            <h3 class="fw-bold mb-0 text-uppercase">SEMEN TONASA MEDICAL CENTER</h3>
            <p class="mb-0">Jl. Beruang No. 1 Biringere Kec. Bungoro Kab. Pangkep 90651</p>
            <p class="mb-0 small">Telp.0410-310062 Fax 0410-31018</p>
            <p class="mb-0 small">Email: medicalcentre.st@sementonasaindonesia.com</p>
        </div>

        {{-- JUDUL LAPORAN --}}
        <div class="text-center mb-4">
            <h5 class="fw-bold text-decoration-underline">LAPORAN REKAPITULASI ARSIP SURAT</h5>
            <p class="mb-0">
                <strong>Periode:</strong> {{ \Carbon\Carbon::parse($awal)->translatedFormat('d F Y') }}
                s/d {{ \Carbon\Carbon::parse($akhir)->translatedFormat('d F Y') }}
            </p>
            <p class="mb-0"><strong>Filter Kategori:</strong> {{ ucfirst($jenis) }}</p>
        </div>

        {{-- TABEL DATA --}}
        <table class="table table-bordered align-middle w-100">
            <thead>
                <tr class="text-center text-uppercase small fw-bold">
                    <th width="5%">No</th>
                    <th width="15%">No. Surat</th>
                    <th width="13%">Tanggal</th>
                    <th width="10%">Jenis</th>
                    <th width="30%">Perihal / Judul</th>
                    <th width="15%">Kategori</th>
                    <th width="12%">Scan File</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $key => $surat)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>

                    {{-- Kolom Nomor Surat --}}
                    <td class="fw-bold text-break">
                        @if($surat->foto_bukti)
                            <a href="{{ asset('storage/surat/' . $surat->foto_bukti) }}" target="_blank">
                                {{ $surat->nomor_surat }}
                            </a>
                        @else
                            {{ $surat->nomor_surat }}
                        @endif
                    </td>

                    <td class="text-center">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d/m/Y') }}</td>

                    <td class="text-center text-uppercase small">
                        {{ ucfirst($surat->category->jenis) }}
                    </td>

                    <td>{{ $surat->nama_surat }}</td>

                    {{-- Perbaikan: Mengambil nama kategori dari relasi --}}
                    <td>{{ $surat->category->nama_kategori }}</td>

                    {{-- Kolom QR Code --}}
                    <td class="text-center">
                        @if($surat->foto_bukti)
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ asset('storage/surat/' . $surat->foto_bukti) }}"
                                 class="qr-box" width="50" height="50" alt="QR">
                        @else
                            <span class="small text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center p-4 fst-italic text-muted">
                        Tidak ada data surat pada periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- TANDA TANGAN --}}
        <div class="row mt-5 avoid-break">
            <div class="col-4 offset-8 text-center">
                <p class="mb-1">Biring ere, {{ date('d F Y') }}</p>
                <p class="mb-5">Mengetahui, <br> Kepala Klinik Semen Tonasa Medical Center</p>
                <br>
                <p class="fw-bold text-decoration-underline mb-0">Nama Pejabat, S.kom</p>
                <p class="small">NIP. 19980101 202401 1 001</p>
            </div>
        </div>

    </div>
</body>
</html>
