@extends('templates.master')

@section('title', 'Kategori Obat')

@section('content')
<div class="container-fluid px-0">
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Kategori Obat</h4>
            <p class="text-muted small mb-0">Manajemen kelompok atau jenis sediaan obat-obatan.</p>
        </div>
        <a href="{{ route('kategori_obat.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-plus-circle"></i>
            <span>Tambah Kategori</span>
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="myTable">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="ps-4 py-3" style="width: 80px;">No</th>
                            <th class="py-3">Nama Kategori</th>
                            <th class="pe-4 py-3 text-end" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="small text-dark">
                        @forelse($kategori as $index => $item)
                            <tr>
                                <td class="ps-4 fw-semibold text-secondary">{{ $index + 1 }}</td>
                                <td class="fw-bold text-primary">{{ $item->nama_kategori }}</td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('kategori_obat.edit', $item->id) }}" class="btn btn-sm btn-outline-warning d-flex align-items-center gap-1 px-2.5" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <form action="{{ route('kategori_obat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori [{{ $item->nama_kategori }}]? Data obat yang terkait mungkin akan terdampak.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 px-2.5" title="Hapus Data">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <div class="mb-2">
                                        <i class="bi bi-folder-x fs-1 text-secondary opacity-50"></i>
                                    </div>
                                    <span class="d-block small fw-semibold">Belum ada data kategori obat.</span>
                                    <span class="text-muted d-block extra-small">Silakan klik tombol "Tambah Kategori" untuk menginput data baru.</span>
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