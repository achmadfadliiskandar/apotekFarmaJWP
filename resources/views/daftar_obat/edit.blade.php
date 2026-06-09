@extends('templates.master')

@section('title', 'Edit Data Obat')

@section('content')
<div class="container-fluid px-0" style="max-width: 850px;">
    
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('daftar_obat.index') }}" class="btn btn-sm btn-outline-secondary rounded-circle px-2">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold text-dark mb-1">Edit Informasi Obat</h4>
            <p class="text-muted small mb-0">Ubah spesifikasi, kuantitas data induk obat terdaftar.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm bg-white">
        <div class="card-body p-4">
            <form action="{{ route('daftar_obat.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label for="kode_obat" class="form-label fw-semibold small text-secondary">Kode Obat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode_obat') is-invalid @enderror" id="kode_obat" name="kode_obat" readonly value="{{ old('kode_obat', $obat->kode_obat) }}" required>
                        @error('kode_obat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-8">
                        <label for="kategori_obat_id" class="form-label fw-semibold small text-secondary">Kategori Kelompok <span class="text-danger">*</span></label>
                        <select class="form-select @error('kategori_obats_id') is-invalid @enderror" id="kategori_obats_id" name="kategori_obats_id" required>
                            @foreach($kategori as $cat)
                                <option value="{{ $cat->id }}" {{ old('kategori_obat_id', $obat->kategori_obat_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_obats_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="nama_obat" class="form-label fw-semibold small text-secondary">Nama Lengkap Obat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" id="nama_obat" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                    @error('nama_obat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="stok" class="form-label fw-semibold small text-secondary">Penyesuaian Fisik Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ old('stok', $obat->stok) }}" min="0" required>
                        @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="satuan" class="form-label fw-semibold small text-secondary">Satuan Sediaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan', $obat->satuan) }}" required>
                        @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="{{ route('daftar_obat.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-warning text-dark fw-semibold px-4"><i class="bi bi-check-circle me-1"></i> Sinkronkan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection