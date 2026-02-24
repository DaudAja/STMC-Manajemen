<div class="animate__animated animate__fadeIn">
    {{-- 1. Header & Bilah Pencarian Modern --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h4 class="fw-bold text-dark mb-1">Daftar Surat Masuk</h4>
            <p class="text-muted small mb-0">Manajemen arsip seluruh dokumen dan surat yang diterima oleh STMC.</p>
        </div>
        <div class="col-md-6 mt-3 mt-md-0">
            <form action="{{ route('surat.masuk') }}" method="GET">
                <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-0 ps-0" placeholder="Cari nomor atau perihal..."
                        value="{{ request('search') }}" style="font-size: 0.9rem;">
                    @if (request('search'))
                        <a href="{{ route('surat.masuk') }}" class="btn btn-light border-0 d-flex align-items-center">
                            <i class="bi bi-x-circle me-1"></i> Reset
                        </a>
                    @endif
                    <button class="btn btn-success px-4" type="submit" style="background-color: var(--stmc-primary); border: none;">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 2. Kartu Tabel --}}
    <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8fafc;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">No. Surat</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Nama Surat</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold text-center" style="font-size: 0.75rem; letter-spacing: 0.5px;">Tanggal</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold text-center" style="font-size: 0.75rem; letter-spacing: 0.5px;">Kategori</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold text-center" style="font-size: 0.75rem; letter-spacing: 0.5px;">Oleh</th>
                            <th class="py-3 text-uppercase text-secondary fw-bold text-center pe-4" style="font-size: 0.75rem; letter-spacing: 0.5px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr style="transition: all 0.2s ease;">
                                <td class="ps-4">
                                    <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $item->nomor_surat }}</span>
                                </td>
                                <td>
                                    <div class="fw-medium text-dark" style="font-size: 0.9rem;">{{ $item->nama_surat }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="text-muted" style="font-size: 0.85rem;">
                                        <i class="bi bi-calendar-check me-1"></i>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $color ?? 'primary' }} bg-opacity-10 text-{{ $color ?? 'primary' }} px-3 py-2 rounded-pill border border-{{ $color ?? 'primary' }}-subtle" style="font-size: 0.7rem;">
                                        {{ strtoupper($item->category->sifat) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 25px; height: 25px; font-size: 0.7rem;">
                                            <i class="bi bi-person-fill text-secondary"></i>
                                        </div>
                                        <small class="text-muted fw-medium">{{ $item->user->nama_lengkap ?? 'Admin' }}</small>
                                    </div>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-1">
                                        {{-- 1. Tombol Buka PDF --}}
                                        <a href="{{ asset('storage/surat/' . $item->foto_bukti) }}" target="_blank"
                                            class="btn btn-sm btn-outline-success border-0" title="Buka PDF">
                                            <i class="bi bi-file-earmark-pdf-fill fs-5"></i>
                                        </a>

                                        {{-- 2. Tombol Detail --}}
                                        <a href="{{ route('surat.show', $item->id) }}" class="btn btn-sm btn-outline-info border-0"
                                            title="Detail">
                                            <i class="bi bi-eye-fill fs-5"></i>
                                        </a>

                                        {{-- 3. Tombol Edit --}}
                                        <a href="{{ route('surat.edit', $item->id) }}" class="btn btn-sm btn-outline-primary border-0"
                                            title="Edit">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </a>

                                        {{-- 4. Tombol Hapus dengan Logika Proteksi --}}
                                        @if ($item->category->jenis == 'masuk')
                                            <form action="{{ route('surat.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger border-0"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus surat masuk ini?')">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                        @else
                                            {{-- Kasus jika ada data surat keluar yang nyasar ke sini --}}
                                            <button type="button" class="btn btn-sm btn-outline-secondary border-0 opacity-25"
                                                onclick="alert('Hanya Surat Masuk yang dapat dihapus dari halaman ini.')"
                                                title="Hapus Terkunci">
                                                <i class="bi bi-lock-fill fs-5"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center opacity-75">
                                        <div class="bg-light rounded-circle d-flex justify-content-center align-items-center mb-3" style="width: 80px; height: 80px;">
                                            <i class="bi bi-inbox-fill fs-1 text-muted"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Arsip Kosong</h6>
                                        <p class="text-muted small mb-0">Tidak ada data surat masuk yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
