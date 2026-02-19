<div class="row mb-3 ">
    <div class="col-md-6 offset-md-6 d-flex justify-content-end">
        <form action="{{ route('surat.masuk') }}" method="GET">
            <div class="input-group input-group-sm shadow-sm">
                <input type="text" name="search" class="form-control" placeholder="Cari nomor atau perihal..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
                @if (request('search'))
                    <a href="{{ route('surat.masuk') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="bg-light">
            <tr>
                <th class="pt-4">No. Surat</th>
                <th>Nama Surat</th>
                <th class="text-center">Tanggal Surat</th>
                <th class="text-center">Kategory</th>
                <th class="text-center">Oleh</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
                <tr>
                    <td class="fw-bold text-primary ">{{ $item->nomor_surat }}</td>
                    <td>{{ $item->nama_surat }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d/m/Y') }}</td>
                    <td class="text-center"><span
                            class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }}">{{ $item->category->sifat }}</span>
                    </td>
                    <td class="text-center"><small class="text-muted">{{ $item->user->nama_lengkap ?? 'Admin' }}</small>
                    </td>
                    <td class="text-center">
                        {{-- 1. Tombol Buka PDF --}}
                        <a href="{{ asset('storage/surat/' . $item->foto_bukti) }}" target="_blank"
                            class="btn btn-sm btn-outline-success border-0" title="Buka PDF">
                            <i class="bi bi-file-earmark-pdf-fill"></i> Buka PDF
                        </a>

                        {{-- 2. Tombol Detail --}}
                        <a href="{{ route('surat.show', $item->id) }}" class="btn btn-sm btn-outline-info border-0"
                            title="Detail">
                            <i class="bi bi-eye-fill"></i> Detail
                        </a>

                        {{-- 3. Tombol Edit --}}
                        <a href="{{ route('surat.edit', $item->id) }}" class="btn btn-sm btn-outline-primary border-0"
                            title="Edit">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>

                        {{-- 4. Tombol Hapus dengan Logika Proteksi --}}
                        @if ($item->category->jenis == 'masuk')
                            {{-- WAJIB MENGGUNAKAN FORM UNTUK DELETE --}}
                            <form action="{{ route('surat.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus surat masuk ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        @else
                            {{-- Jika Surat Keluar: Tombol dinonaktifkan/abu-abu --}}
                            <button type="button" class="btn btn-sm btn-outline-secondary border-0 opacity-50"
                                onclick="alert('Surat Keluar tidak boleh dihapus demi integritas nomor urut arsip silahkan gunakan fitur edit untuk koreksi data jika diperlukan.')"
                                title="Hapus Terkunci">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        @endif
                    </td>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">Belum ada data surat di bagian ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
</div>
