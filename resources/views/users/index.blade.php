@extends('templates.master')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid px-0">
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Manajemen Pengguna</h4>
            <p class="text-muted small mb-0">administrator yang berhak mengakses sistem.</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-person-plus"></i>
            <span>Tambah Admin Staff</span>
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
                <table class="table table-hover align-middle mb-0" id="myTable">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="ps-4 py-3" style="width: 70px;">No</th>
                            <th class="py-3">Nama Lengkap</th>
                            <th class="py-3">Email Akun</th>
                            <th class="py-3">Hak Akses / Role</th>
                            <th class="pe-4 py-3 text-end" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="small text-dark">
                        @forelse($users as $index => $user)
                            <tr>
                                <td class="ps-4 fw-semibold text-secondary">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">{{ $user->name }}</td>
                                <td class="text-muted">{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'admin_super')
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1.5 border border-danger border-opacity-10">
                                            <i class="bi bi-shield-lock-fill me-1"></i> Admin Super
                                        </span>
                                    @else
                                        <span class="badge bg-info bg-opacity-10 text-info px-2.5 py-1.5 border border-info border-opacity-10">
                                            <i class="bi bi-person-badge-fill me-1"></i> Admin Staff
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning d-flex align-items-center gap-1 px-2.5">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akun admin staff [{{ $user->name }}]? Petugas ini tidak akan bisa login lagi.');">
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
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <div class="mb-2"><i class="bi bi-people fs-1 opacity-50"></i></div>
                                    <span class="d-block small fw-semibold">Belum ada admin staff lain terdaftar.</span>
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