@extends('templates.master')

@section('title', 'Laporan Mutasi Obat')

@section('content')
    <div class="container-fluid px-0">

        <div class="mb-4">
            <h4 class="fw-bold text-dark mb-1">Laporan Mutasi Stok</h4>
            <p class="text-muted small mb-0">Audit log seluruh aktivitas keluar masuknya komoditas obat berdasarkan rentang
                waktu tertentu.</p>
        </div>

        <div class="card border-0 shadow-sm bg-white mb-4">
            <div class="card-body p-4">
                <form action="{{ route('laporan') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="tanggal_awal" class="form-label fw-semibold small text-secondary">Tanggal
                                Awal</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i
                                        class="bi bi-calendar-date"></i></span>
                                <input type="date" class="form-control border-start-0" id="tanggal_awal"
                                    name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="tanggal_akhir" class="form-label fw-semibold small text-secondary">Tanggal
                                Akhir</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i
                                        class="bi bi-calendar-date"></i></span>
                                <input type="date" class="form-control border-start-0" id="tanggal_akhir"
                                    name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="submit"
                                    class="btn btn-primary flex-fill d-flex align-items-center justify-content-center gap-2 shadow-sm fw-semibold">
                                    <i class="bi bi-filter"></i> Filter Data
                                </button>
                                @if (request('tanggal_awal') || request('tanggal_akhir'))
                                    <a href="{{ route('laporan') }}" class="btn btn-light border" title="Reset Filter">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-md-4  my-3">
                        <div class="row g-2">
                            {{-- Tombol PDF --}}
                            <div class="col-6">
                                <a href="{{ route('laporan.pdf', request()->query()) }}" class="btn btn-danger d-flex align-items-center justify-content-center gap-2 shadow-sm fw-semibold w-100" title="Cetak PDF">
                                    <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                                </a>
                            </div>

                            {{-- Tombol Excel --}}
                            <div class="col-6">
                                <a href="{{ route('laporan.excel', request()->query()) }}" class="btn btn-success d-flex align-items-center justify-content-center gap-2 shadow-sm fw-semibold w-100" title="Ekspor Excel">
                                    <i class="bi bi-file-earmark-excel-fill"></i> Excel
                                </a>
                            </div>
                        </div>

                        @if (request('tanggal_awal') || request('tanggal_akhir'))
                            <a href="{{ route('laporan') }}" class="btn btn-light border d-flex align-items-center justify-content-center gap-2 w-100 small text-secondary" title="Reset Filter">
                                <i class="bi bi-arrow-clockwise"></i> Reset Pencarian
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm bg-white">
            <div class="card-header bg-light py-3 border-0 d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark small">
                    <i class="bi bi-journal-text text-primary me-2"></i>
                    @if (request('tanggal_awal') && request('tanggal_akhir'))
                        Menampilkan Rekonstruksi Data Periode: <span
                            class="text-primary">{{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d/m/Y') }}</span>
                        s/d <span
                            class="text-primary">{{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') }}</span>
                    @else
                        Seluruh Riwayat Log Transaksi
                    @endif
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small">
                            <tr>
                                <th class="ps-4 py-3" style="width: 70px;">No</th>
                                <th class="py-3">Daftar Obat ID</th>
                                <th class="py-3">User ID</th>
                                <th class="py-3" style="width: 140px;">Jenis</th>
                                <th class="py-3">Jumlah</th>
                                <th class="py-3">Tanggal</th>
                                <th class="pe-4 py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="small text-dark">
                            @isset($semuaMutasi)
                                @forelse($semuaMutasi as $index => $mutasi)
                                    <tr>
                                        <td class="ps-4 fw-semibold text-secondary">{{ $index + 1 }}</td>

                                        <td>
                                            <div class="fw-bold text-dark">{{ $mutasi->daftar_obats_id }}</div>
                                            <div class="text-muted extra-small">
                                                {{ $mutasi->daftarObat->nama_obat ?? 'Obat Tidak Ditemukan' }}</div>
                                        </td>

                                        <td>
                                            <div class="fw-semibold text-secondary">ID: {{ $mutasi->user_id }}</div>
                                            <div class="text-muted extra-small"><i
                                                    class="bi bi-person me-1"></i>{{ $mutasi->user->name ?? 'System' }}</div>
                                        </td>

                                        <td>
                                            @if ($mutasi->jenis == 'masuk')
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-2 py-1.5 w-100 text-center text-uppercase fw-bold"
                                                    style="font-size: 0.75rem;">
                                                    <i class="bi bi-arrow-down-left-circle-fill me-1"></i> {{ $mutasi->jenis }}
                                                </span>
                                            @else
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-20 px-2 py-1.5 w-100 text-center text-uppercase fw-bold"
                                                    style="font-size: 0.75rem;">
                                                    <i class="bi bi-arrow-up-right-circle-fill me-1"></i> {{ $mutasi->jenis }}
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <span
                                                class="fw-bold fs-6 {{ $mutasi->jenis == 'masuk' ? 'text-success' : 'text-danger' }}">
                                                {{ $mutasi->jenis == 'masuk' ? '+' : '-' }}{{ $mutasi->jumlah }}
                                            </span>
                                            <span class="text-muted extra-small">{{ $mutasi->daftarObat->satuan ?? '' }}</span>
                                        </td>

                                        <td class="text-muted">
                                            {{ \Carbon\Carbon::parse($mutasi->tanggal)->translatedFormat('d M Y') }}
                                        </td>

                                        <td class="pe-4 text-muted">
                                            {{ $mutasi->keterangan ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <div class="mb-2"><i class="bi bi-folder-x fs-1 opacity-50"></i></div>
                                            <span class="d-block small fw-semibold">Tidak ditemukan kecocokan data mutasi obat
                                                pada rentang waktu tersebut.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <div class="mb-2"><i class="bi bi-cloud-arrow-down text-primary fs-2 opacity-50"></i>
                                        </div>
                                        <span class="d-block small fw-semibold">Menghubungkan rekap data log gudang...</span>
                                    </td>
                                </tr>
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
