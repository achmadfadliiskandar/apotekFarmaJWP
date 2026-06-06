@extends('templates.master')

@section('title', 'Daftar Obat')

@section('content')
<div class="container-fluid px-0">
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Daftar Stok Obat</h4>
            <p class="text-muted small mb-0">Manajemen katalog produk, satuan sediaan, dan kontrol kuantitas stok gudang.</p>
        </div>
        <a href="{{ route('daftar_obat.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-plus-circle"></i>
            <span>Tambah Obat Baru</span>
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="ps-4 py-3" style="width: 70px;">No</th>
                            <th class="py-3">Kode Obat</th>
                            <th class="py-3">Nama Obat</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3">Stok / Satuan</th>
                            <th class="pe-4 py-3 text-end" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="small text-dark">
                        @forelse($daftarObat as $index => $item)
                            <tr>
                                <td class="ps-4 fw-semibold text-secondary">{{ $index + 1 }}</td>
                                <td><span class="badge bg-light text-dark border px-2 py-1.5 fw-mono">{{ $item->kode_obat }}</span></td>
                                <td class="fw-bold text-dark">{{ $item->nama_obat }}</td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1.5 border border-primary border-opacity-10">
                                        {{ $item->kategoriObat->nama_kategori ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $item->stok }}</span> <span class="text-muted small">{{ $item->satuan }}</span>
                                    
                                    @if($item->stok == 0)
                                        <span class="badge bg-dark ms-2"><i class="bi bi-x-circle-fill me-1"></i> Habis</span>
                                    @elseif($item->stok < 10)
                                        <span class="badge bg-danger ms-2 animate-pulse"><i class="bi bi-flag-fill me-1"></i> Kritis</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('daftar_obat.edit', $item->id) }}" class="btn btn-sm btn-outline-warning d-flex align-items-center gap-1 px-2.5">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('daftar_obat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data obat [{{ $item->nama_obat }}]? Tindakan ini tidak dapat dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 px-2.5">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="mb-2"><i class="bi bi-capsule-extinguisher fs-1 opacity-50"></i></div>
                                    <span class="d-block small fw-semibold">Katalog produk obat masih kosong.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection