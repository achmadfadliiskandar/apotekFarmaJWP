@extends('templates.master')

@section('title', 'Transaksi Stok Keluar')

@section('content')
<div class="container-fluid px-0">
    
    <div class="mb-4">
        <h4 class="fw-bold text-dark mb-1">Transaksi Stok Keluar</h4>
        <p class="text-muted small mb-0">Pencatatan mutasi obat keluar gudang. Sistem akan otomatis menolak jika jumlah pengeluaran melebihi sisa stok fisik.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm bg-white mb-4">
        <div class="card-header bg-light py-3 border-0">
            <span class="fw-bold text-dark small"><i class="bi bi-minus-square-fill text-danger me-2"></i>Form Tambah Stok Keluar</span>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('stok-keluar.store') }}" method="POST">
                @csrf
                
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="daftar_obats_id" class="form-label fw-semibold small text-secondary">Pilih Obat <span class="text-danger">*</span></label>
                        <select class="form-select @error('daftar_obats_id') is-invalid @enderror" id="daftar_obats_id" name="daftar_obats_id" required>
                            <option value="" selected disabled>-- Pilih Obat --</option>
                            {{-- Looping data obat dari controller --}}
                            @isset($daftarObat)
                                @foreach($daftarObat as $obat)
                                    <option value="{{ $obat->id }}" {{ old('daftar_obat_id') == $obat->id ? 'selected' : '' }}>
                                        [{{ $obat->kode_obat }}] {{ $obat->nama_obat }} (Sisa: {{ $obat->stok }} {{ $obat->satuan }})
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @error('daftar_obats_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label for="jumlah" class="form-label fw-semibold small text-secondary">Jumlah Keluar <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" placeholder="0" required>
                        @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="keterangan" class="form-label fw-semibold small text-secondary">Keterangan / Alasan Keluar</label>
                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" placeholder="Contoh: Resep Dokter, Obat Kadaluwarsa, Rusak">
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2 shadow-sm fw-semibold">
                            <i class="bi bi-upload"></i>
                            <span>Keluarkan Stok</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm bg-white">
        <div class="card-header bg-light py-3 border-0">
            <span class="fw-bold text-dark small"><i class="bi bi-clock-history text-secondary me-2"></i>Riwayat Seluruh Stok Keluar</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="ps-4 py-3" style="width: 70px;">No</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Kode Transaksi</th>
                            <th class="py-3">Nama Obat</th>
                            <th class="py-3">Jumlah Keluar</th>
                            <th class="py-3">Keterangan / Alasan</th>
                            <th class="pe-4 py-3">Petugas (User)</th>
                        </tr>
                    </thead>
                    <tbody class="small text-dark">
                        {{-- Data looping dari tabel mutasi_obat dengan jenis 'keluar' --}}
                        @isset($mutasiKeluar)
                            @forelse($mutasiKeluar as $index => $mutasi)
                                <tr>
                                    <td class="ps-4 fw-semibold text-secondary">{{ $index + 1 }}</td>
                                    <td class="text-muted">{{ \Carbon\Carbon::parse($mutasi->tanggal)->translatedFormat('d M Y H:i') }}</td>
                                    <td><span class="badge bg-light text-dark border px-2 py-1.5 fw-mono">{{ $mutasi->kode_transaksi }}</span></td>
                                    <td class="fw-bold text-danger">{{ $mutasi->daftarObat->nama_obat ?? 'Obat Dihapus' }}</td>
                                    <td>
                                        <span class="text-danger fw-bold"> -{{ $mutasi->jumlah }}</span> 
                                        <span class="text-muted extra-small">{{ $mutasi->daftarObat->satuan ?? '' }}</span>
                                    </td>
                                    <td class="text-muted">{{ $mutasi->keterangan ?? '-' }}</td>
                                    <td class="pe-4 fw-semibold text-secondary"><i class="bi bi-person me-1"></i>{{ $mutasi->user->name ?? 'System' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <div class="mb-2"><i class="bi bi-folder-x fs-1 opacity-50"></i></div>
                                        <span class="d-block small fw-semibold">Belum ada riwayat transaksi stok keluar.</span>
                                    </td>
                                </tr>
                            @endforelse
                        @else
                            {{-- Tampilan Default Sebelum Data Dikirim dari Controller --}}
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div class="mb-2"><i class="bi bi-arrow-up-right-circle text-danger fs-2 opacity-50"></i></div>
                                    <span class="d-block small fw-semibold">Menunggu sinkronisasi database mutasi keluar...</span>
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