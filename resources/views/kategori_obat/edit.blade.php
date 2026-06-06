@extends('templates.master')

@section('title', 'Edit Kategori Obat')

@section('content')
<div class="container-fluid px-0" style="max-width: 800px;">
    
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('kategori_obat.index') }}" class="btn btn-sm btn-outline-secondary rounded-circle px-2">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold text-dark mb-1">Edit Kategori Obat</h4>
            <p class="text-muted small mb-0">Ubah informasi kelompok sediaan obat yang sudah terdaftar.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm bg-white">
        <div class="card-body p-4">
            <form action="{{ route('kategori_obat.update', $kategori->id) }}" method="POST">
                @csrf 
                @method('PUT') <div class="mb-3">
                    <label for="nama_kategori" class="form-label fw-semibold small text-secondary">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('nama_kategori') is-invalid @enderror" 
                           id="nama_kategori" 
                           name="nama_kategori" 
                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                           required>
                    
                    @error('nama_kategori')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="{{ route('kategori_obat.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-warning text-dark px-4fw-semibold">
                        <i class="bi bi-check-circle me-1"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection