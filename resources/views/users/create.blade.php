@extends('templates.master')

@section('title', 'Tambah Petugas Baru')

@section('content')
<div class="container-fluid px-0" style="max-width: 800px;">
    
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary rounded-circle px-2">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold text-dark mb-1">Tambah Petugas Baru</h4>
            <p class="text-muted small mb-0">Daftarkan akun operator atau admin baru untuk operasional sistem.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm bg-white">
        <div class="card-body p-4">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold small text-secondary">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap petugas" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold small text-secondary">Alamat Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Contoh: petugas@jewepefarma.com" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold small text-secondary">Kata Sandi / Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 6 karakter" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="form-label fw-semibold small text-secondary">Level Hak Akses / Role <span class="text-danger">*</span></label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                        <option value="" selected disabled>-- Pilih Level Akses --</option>
                        <option value="admin_staff" {{ old('role') == 'admin_staff' ? 'selected' : '' }}>Admin Staff (Operator)</option>
                        <option value="admin_utama" {{ old('role') == 'admin_utama' ? 'selected' : '' }}>Admin Utama (Full Access)</option>
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="{{ route('users.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Daftarkan Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection