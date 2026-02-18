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
                        <a href="{{ asset('storage/surat/' . $item->foto_bukti) }}" target="_blank"
                            class="btn btn-sm btn-outline-success border-0">
                            <i class="bi bi-file-earmark-pdf-fill"></i> Buka
                        </a>

                        <a href="{{ route('surat.show', $item->id) }}" class="btn btn-sm btn-outline-success border-0">
                            <i class="bi bi-eye-fill"></i> Detail
                        </a>

                        <a href="{{ route('surat.edit', $item->id) }}" class="btn btn-sm btn-outline-primary border-0">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
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
