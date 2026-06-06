@extends('templates.master')

@section('title', 'Transaksi Stok Masuk')

@section('content')
<div class="container-fluid px-0">
    
    <div class="mb-4">
        <h4 class="fw-bold text-dark mb-1">Transaksi Stok Masuk</h4>
        <p class="text-muted small mb-0">Pencatatan suplai obat masuk. User pencatat, nomor transaksi, jenis, dan tanggal akan diisi otomatis oleh sistem.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm bg-white mb-4">
        <div class="card-header bg-light py-3 border-0">
            <span class="fw-bold text-dark small"><i class="bi bi-plus-square-fill text-success me-2"></i>Form Tambah Stok Masuk</span>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('stok-masuk.store') }}" method="POST">
                @csrf
                
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="daftar_obat_id" class="form-label fw-semibold small text-secondary">Pilih Obat <span class="text-danger">*</span></label>
                        <select class="form-select @error('daftar_obat_id') is-invalid @enderror" id="daftar_obats_id" name="daftar_obats_id" required>
                            <option value="" selected disabled>-- Pilih Obat --</option>
                            {{-- Looping data obat dari controller --}}
                            @isset($daftarObat)
                                @foreach($daftarObat as $obat)
                                    <option value="{{ $obat->id }}" {{ old('daftar_obats_id') == $obat->id ? 'selected' : '' }}>
                                        [{{ $obat->kode_obat }}] {{ $obat->nama_obat }} (Sisa: {{ $obat->stok }} {{ $obat->satuan }})
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @error('daftar_obats_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label for="jumlah" class="form-label fw-semibold small text-secondary">Jumlah Masuk <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" placeholder="0" required>
                        @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="keterangan" class="form-label fw-semibold small text-secondary">Keterangan / Supplier / PBF</label>
                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" placeholder="Contoh: PBF Kimia Farma, PT. Kalbe">
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 shadow-sm">
                            <i class="bi bi-download"></i>
                            <span>Simpan Stok</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm bg-white">
        <div class="card-header bg-light py-3 border-0">
            <span class="fw-bold text-dark small"><i class="bi bi-clock-history text-secondary me-2"></i>Riwayat Seluruh Stok Masuk</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="myTable">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="ps-4 py-3" style="width: 70px;">No</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Nama Obat</th>
                            <th class="py-3">Jumlah Masuk</th>
                            <th class="py-3">Keterangan / Sumber</th>
                            <th class="pe-4 py-3">Petugas (User)</th>
                        </tr>
                    </thead>
                    <tbody class="small text-dark">
                        {{-- Data looping dari tabel mutasi_obat --}}
                        @isset($mutasiMasuk)
                            @forelse($mutasiMasuk as $index => $mutasi)
                                <tr>
                                    <td class="ps-4 fw-semibold text-secondary">{{ $index + 1 }}</td>
                                    <td class="text-muted">{{ \Carbon\Carbon::parse($mutasi->tanggal)->translatedFormat('d M Y H:i') }}</td>
                                    <td class="fw-bold text-primary">{{ $mutasi->daftarObat->nama_obat ?? 'Obat Dihapus' }}</td>
                                    <td>
                                        <span class="text-success fw-bold">+{{ $mutasi->jumlah }}</span> 
                                        <span class="text-muted extra-small">{{ $mutasi->daftarObat->satuan ?? '' }}</span>
                                    </td>
                                    <td class="text-muted">{{ $mutasi->keterangan ?? '-' }}</td>
                                    <td class="pe-4 fw-semibold text-secondary"><i class="bi bi-person me-1"></i>{{ $mutasi->user->name ?? 'System' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <div class="mb-2"><i class="bi bi-folder-x fs-1 opacity-50"></i></div>
                                        <span class="d-block small fw-semibold">Belum ada riwayat transaksi stok masuk.</span>
                                    </td>
                                </tr>
                            @endforelse
                        @else
                            {{-- Tampilan Default Sebelum Data Dikirim dari Controller --}}
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div class="mb-2"><i class="bi bi-arrow-down-left-circle text-success fs-2 opacity-50"></i></div>
                                    <span class="d-block small fw-semibold">Menunggu sinkronisasi database mutasi obat...</span>
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